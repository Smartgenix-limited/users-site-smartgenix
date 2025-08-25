<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Http\Requests\ServiceRequest;
use App\Mail\ServiceCreated;
use App\Models\Payment;
use App\Models\ServiceAppointment;
use App\Models\User;
use App\Notifications\OrderThankYouNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ServiceAppointmentController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('offer_services');
        $this->authorizeResource(ServiceAppointment::class, 'service');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $admins = User::where('type', 'admin')->get();
        $time = $request->date . ' ' . $request->time;
        $due = date("Y-m-d H:i:s", strtotime($time));
        $cars = explode(",", $request->cars);
        foreach ($cars as $key => $car) {
            $service = $request->user()->services()->create([
                'car_id' => $car,
                'type_of_service' => $request->type_of_service,
                'price' => $request->amount ?? setting($request->type_of_service . '_service'),
                'payment' => can_service() ? PaymentStatus::Paid : ($request->payment_id ? PaymentStatus::Paid : 'pending'),
                'payment_id' => $request->payment_id,
                'datetime' => Carbon::parse($due)->addMinutes(($key * 30)),
            ]);

            // updating user subscription
            if (can_service()) {
                update_subscription('services');
            }

            Mail::to($request->user())->send(new ServiceCreated($service, 'Service'));
        }

        return to_route('services.success', $service)->with('success', trans('general.service_action', ['service' => trans('general.service'), 'action' => trans('general.created')]));
        // return redirect()->back()->with('success', 'Service Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceAppointment  $service
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceAppointment $service)
    {
        $service->load('tasks');

        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceAppointment  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceAppointment $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceAppointment  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceAppointment $service)
    {
        $request->validate([
            'date' => 'required',
            'time' => 'required',
        ]);

        $time = $request->date . ' ' . $request->time;
        $due = date("Y-m-d H:i:s", strtotime($time));
        $service->update(['datetime' => $due,]);

        return redirect()->back()->with('success', trans('general.service_action', ['service' => trans('general.service'), 'action' => trans('general.updated')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceAppointment  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceAppointment $service)
    {
        $service->delete();

        return redirect()->back()->with('success', trans('general.service_action', ['service' => trans('general.service'), 'action' => trans('general.deleted')]));
    }

    /**
     * Show the success screen for the specified resource.
     *
     * @param  \App\Models\ServiceAppointment  $service
     * @return \Illuminate\Http\Response
     */
    public function success(ServiceAppointment $service)
    {
        $service->load('car');
        return view('services.success', compact('service'));
    }

    /**
     * Display a information of the services.
     *
     * @return \Illuminate\Http\Response
     */
    public function information()
    {
        return view('services.information');
    }
}
