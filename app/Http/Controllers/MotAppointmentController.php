<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Http\Requests\MotRequest;
use App\Mail\ServiceCreated;
use App\Models\CarInfo;
use App\Models\MotAppointment;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\OrderThankYouNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class MotAppointmentController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('offer_mot');
        $this->authorizeResource(MotAppointment::class, 'mot');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mots.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MotRequest $request)
    {
        $admins = User::where('type', 'admin')->get();
        $time = $request->date . ' ' . $request->time;
        $due = date("Y-m-d H:i:s", strtotime($time));
        $cars = explode(",", $request->cars);
        foreach ($cars as $key => $car) {
            $mot = $request->user()->mots()->create([
                'car_id' => $car,
                'price' => $request->amount ?? setting('mot_price'),
                'payment' => can_mot() ? PaymentStatus::Paid : ($request->payment_id ? PaymentStatus::Paid : 'pending'),
                'payment_id' => $request->payment_id,
                'datetime' => Carbon::parse($due)->addMinutes(($key * 30)),
            ]);

            // updating user subscription
            if (can_mot()) {
                update_subscription('mots');
            }

            Mail::to($request->user())->send(new ServiceCreated($mot, 'MOT'));
        }

        return to_route('mots.success', $mot)->with('success', trans('general.service_action', ['service' => trans('general.mot'), 'action' => trans('general.created')]));
        // return redirect()->back()->with('success', 'MOT Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MotAppointment  $mot
     * @return \Illuminate\Http\Response
     */
    public function show(MotAppointment $mot)
    {
        $mot->load('mot_task');
        return view('mots.show', compact('mot'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MotAppointment  $mot
     * @return \Illuminate\Http\Response
     */
    public function edit(MotAppointment $mot)
    {
        return view('mots.edit', compact('mot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MotAppointment  $mot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MotAppointment $mot)
    {
        $request->validate([
            'date' => 'required',
            'time' => 'required',
        ]);

        $time = $request->date . ' ' . $request->time;
        $due = date("Y-m-d H:i:s", strtotime($time));
        $mot->update(['datetime' => $due,]);

        return redirect()->back()->with('success', trans('general.service_action', ['service' => trans('general.mot'), 'action' => trans('general.updated')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MotAppointment  $mot
     * @return \Illuminate\Http\Response
     */
    public function destroy(MotAppointment $mot)
    {
        $mot->delete();
        return redirect()->back()->with('success', trans('general.service_action', ['service' => trans('general.mot'), 'action' => trans('general.deleted')]));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        $time = $request->date . ' ' . $request->time;
        $due = date("Y-m-d H:i:s", strtotime($time));
        if ($request->type === 'mot') {
            $mot = MotAppointment::where('datetime', $due)->first();
            if ($mot) {
                return response(['success' => false, 'message' => 'This time slot is not available!']);
            }
        }
        return response(['success' => true, 'message' => trans('general.no_timeslot')]);
    }

    /**
     * Show the success screen for the specified resource.
     *
     * @param  \App\Models\MotAppointment $mot
     * @return \Illuminate\Http\Response
     */
    public function success(MotAppointment $mot)
    {
        $mot->load('car');
        return view('mots.success', compact('mot'));
    }
}
