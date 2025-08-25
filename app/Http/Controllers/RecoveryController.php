<?php

namespace App\Http\Controllers;

use App\Enums\RecoveryStatus;
use App\Enums\UserType;
use App\Models\Recovery;
use App\Http\Requests\RecoveryRequest;
use App\Mail\RecoveryCompanyNotice;
use App\Mail\RecoveryCreated;
use App\Models\Garage as Garage;
use App\Models\RecoveryQuote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RecoveryController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('offer_recovery');
        $this->authorizeResource(Recovery::class, 'recovery');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('recoveries.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['types'] = ['home', 'garage', 'other', 'none'];
        $data['assistance'] = ['yes', 'no'];
        $data['payments'] = ['cash', 'card'];

        return view('recoveries.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RecoveryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecoveryRequest $request)
    {
        $data = $request->validated();
        $data['car_id'] = $data['cars'];
        $data['type'] = $data['type'] === 'other' ? $data['other'] : $data['type'];
        $data['roadside_assistance'] = $data['roadside_assistance'] === 'yes' ? true : false;

        $recovery = $request->user()->recoveries()->create($data);

        Mail::to($request->user())->send(new RecoveryCreated($recovery));

        $users = User::select(['id', 'first_name', 'last_name', 'email'])->whereType(UserType::Recovery)->get();
        foreach ($users as $user) {
            Mail::to($user)->send(new RecoveryCompanyNotice($user));
        }
        $garages = Garage::with('user:id,first_name,last_name,email')->where('is_recovery', true)->get();
        foreach ($garages as $garage) {
            Mail::to($garage->user)->send(new RecoveryCompanyNotice($garage->user));
        }

        return to_route('recoveries.index')->with('success', trans('recoveries.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recovery  $recovery
     * @return \Illuminate\Http\Response
     */
    public function show(Recovery $recovery)
    {
        $recovery->load('quotes.user', 'completer', 'comments');

        return view('recoveries.show', compact('recovery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recovery  $recovery
     * @return \Illuminate\Http\Response
     */
    public function edit(Recovery $recovery)
    {
        $data['types'] = ['home', 'garage', 'other', 'none'];
        $data['assistance'] = ['yes', 'no'];
        $data['payments'] = ['cash', 'card'];

        return view('recoveries.edit', compact('recovery', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RecoveryRequest  $request
     * @param  \App\Models\Recovery  $recovery
     * @return \Illuminate\Http\Response
     */
    public function update(RecoveryRequest $request, Recovery $recovery)
    {
        $data = $this->prepare($request->validated());

        $recovery->update($data);

        return to_route('recoveries.index')->with('success', trans('recoveries.recovery_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recovery  $recovery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recovery $recovery)
    {
        $recovery->quotes()->delete();
        $recovery->completer()->delete();
        $recovery->comments()->delete();
        $recovery->delete();

        return to_route('recoveries.index')->with('success', trans('recoveries.recovery_deleted'));
    }

    private function prepare($data)
    {
        if (isset($data['cars'])) {
            $data['car_id'] = $data['cars'];
        }
        $data['type'] = $data['type'] === 'other' ? $data['other'] : $data['type'];
        $data['roadside_assistance'] = $data['roadside_assistance'] === 'yes' ? true : false;
        // $data['garage_id'] = active_garage();

        return $data;
    }

    /**
     * Select a quote to complete recovery.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Recovery  $recovery
     * @return \Illuminate\Http\Response
     */
    public function select_quote(Request $request, Recovery $recovery)
    {
        $quote = RecoveryQuote::find($request->quote_id);

        if (can_recovery() && $quote->quote_user_id == request()->user()->subscription->garage_id) {
            $price = discount_price($quote->price);
            request()->user()->subscription()->update(['recoveries' => --request()->user()->subscription->recoveries]);
        } else {
            $price = $quote->price;
        }

        $recovery->completer()->create([
            'quote_user_id' => $quote->quote_user_id,
            'price' => $price,
            'time_to_come' => $quote->time_to_come,
        ]);

        return back()->with('success', trans('recoveries.recovery_selected'));
    }

    /**
     * Complete the recovery job.
     *
     * @param  \App\Models\Recovery  $recovery
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request, Recovery $recovery)
    {
        $recovery->update([
            'status' => RecoveryStatus::Completed,
            'approved' => true,
        ]);

        $recovery->completer()->update([
            'completed_at' => now(),
        ]);


        return back()->with('success', trans('recoveries.recovery_completed'));
    }
}
