<?php

namespace App\Http\Controllers;

use App\Mail\CompanySelected;
use App\Mail\UserAddedToCompany;
use App\Models\Garage;
use App\Models\GarageReport;
use App\Models\GarageUser;
use App\Models\UserGarage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SelectGarageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('select_garage.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Garage  $garage
     * @return \Illuminate\Http\Response
     */
    public function show(Garage $garage)
    {
        $garage->load(['reviews.user:id,first_name,last_name', 'reviews.replied_by:id,first_name,last_name', 'user:id,email',])->loadAvg('reviews', 'rating');
        // dd($garage->ratings);
        return view('select_garage.show', compact('garage'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Garage  $garage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Garage $garage)
    {
        // delete all upcoming mots,repairs and services
        $old_garage = active_garage();
        $request->user()->mots()->where('garage_id', $old_garage)->where('datetime', '>', now())->delete();
        $request->user()->services()->where('garage_id', $old_garage)->where('datetime', '>', now())->delete();
        $upcoming_repairs = $request->user()->repairs()->where('garage_id', $old_garage)->where(function ($query) {
            return $query->where('datetime', '>', now())->orWhereNull('datetime');
        })->get();
        foreach ($upcoming_repairs as $repair) {
            $repair->repair_work_message()?->delete();
            $repair->repair_work_details()?->delete();
            $repair?->delete();
        }

        // delete user old membership
        $request->user()->subscription()?->delete();

        $result =  GarageUser::updateOrCreate([
            'user_id' => auth()->id(),
        ], [
            'garage_id' => $garage->id
        ]);

        Mail::to($request->user())->send(new CompanySelected($garage));

        Mail::to($garage->user)->send(new UserAddedToCompany($garage, $request->user()));
        return to_route('dashboard');
    }

    /**
     * Updating garage id for change from menu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->garage->update([
            'garage_id' => $request->garage_id
        ]);

        return back();
    }

    /**
     * Display selected garage information.
     *
     * @return \Illuminate\Http\Response
     */
    public function selected()
    {
        return view('garage.selected', [
            'garage' => Garage::find(active_garage())
        ]);
    }

    /**
     * Review a garage.
     *
     * @return \Illuminate\Http\Response
     */
    public function review()
    {
        return view('garage.review');
    }

    /**
     * Report a garage.
     *
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $garage = Garage::find(active_garage());

        $garage->reports()->create([
            'user_id' => auth()->id(),
            'reason' => $request->reason,
        ]);

        return back()->with('success', trans('garage.reported_success'));
    }
}
