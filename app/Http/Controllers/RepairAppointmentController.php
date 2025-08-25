<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Mail\GarageRepair;
use App\Mail\QuoteAccepted;
use App\Mail\RepairCreated;
use App\Mail\ServiceCreated;
use App\Models\RepairAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RepairAppointmentController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('offer_repairs');
        $this->authorizeResource(RepairAppointment::class, 'repair');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('repairs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('repairs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'cars' => 'required',
        ]);

        $repair = $request->user()->repairs()->create([
            'car_id' => $request->cars,
        ]);

        $repair->repair_work_message()->create([
            'description' => $request->message,
            'images' => $request->images ? json_decode($request->images, true) : [],
            'videos' => $request->videos ? json_decode($request->videos, true) : [],
        ]);

        $repair->load(['car:id,car_name,model,reg', 'garage:id,name,telephone', 'user:id,first_name,last_name', 'repair_work_message']);

        Mail::to($request->user())->send(new RepairCreated($repair));
        Mail::to(garage()->user)->send(new GarageRepair(garage()));

        return redirect()->back()->with('success', trans('general.repair_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RepairAppointment  $repair
     * @return \Illuminate\Http\Response
     */
    public function show(RepairAppointment $repair)
    {
        $repair->load(['repair_work_message', 'repair_work_details', 'tasks', 'car']);

        return view('repairs.show', compact('repair'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RepairAppointment  $repair
     * @return \Illuminate\Http\Response
     */
    public function edit(RepairAppointment $repair)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RepairAppointment  $repair
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RepairAppointment $repair)
    {
        $payment = can_repair() ? ($request->type === 'rejected' ? PaymentStatus::Pending : PaymentStatus::Paid) : PaymentStatus::Pending;
        $repair->update(['job_approval' => $request->type, 'payment' => $payment]);

        // updating user subscription
        if (can_repair() && $request->type === 'approved') {
            Mail::to(garage()->user)->send(new QuoteAccepted($repair, garage()));
            update_subscription('repairs');
        }

        return redirect()->back()->with('success', trans('general.service_action', ['service' => trans('general.quote'), 'action' => trans('general.updated')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RepairAppointment  $repair
     * @return \Illuminate\Http\Response
     */
    public function destroy(RepairAppointment $repair)
    {
        $route = url()->previous() === route('repairs.index') ? 'repairs.index' : 'dashboard';
        $repair->repair_work_message()->delete();
        $repair->repair_work_details()->delete();
        $repair->tasks()->delete();
        $repair->delete();

        return redirect()->route($route)->with('success', trans('general.service_action', ['service' => trans('general.quote'), 'action' => trans('general.deleted')]));
    }
}
