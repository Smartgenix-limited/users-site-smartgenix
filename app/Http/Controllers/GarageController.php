<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Enums\PaymentStatus;
use App\Http\Requests\GarageRequest;
use App\Mail\NewCarCreated;
use App\Models\CarInfo;
use App\Models\MotAppointment;
use App\Traits\FileUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class GarageController extends Controller
{
    use FileUpload;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(CarInfo::class, 'garage');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('garage.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('garage.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GarageRequest $request)
    {
        $data = $request->validated();
        // $response = Http::get('http://scrape.smartgenix.co.uk/insert_mot.php?number_plate=' . $data['reg'])->json();
        // dd($response['mot_test_detail'][0]['mot_result'] === 'PASSED');
        if ($request->has('image')) {
            $data['image'] = $this->fileUpload($request->image);
        }

        $car = $request->user()->cars()->create($data);

        // if user is from uk then scrap the mot result and save
        if (is_uk()) {
            $response = Http::get('http://scrape.smartgenix.co.uk/insert_mot.php?number_plate=' . $data['reg'])->json();
            if ($response && isset($response['mot_test_detail'])) {
                foreach ($response['mot_test_detail'] as $item) {
                    $mot = $request->user()->mots()->create([
                        'garage_id' => 1,
                        'car_id' => $car->id,
                        'price' => 0,
                        'payment' => PaymentStatus::Paid,
                        'payment_id' => null,
                        'status' => JobStatus::Completed,
                        'datetime' => carbon(str_replace('.', '-', $item['mot_date']))->format('Y-m-d h:i:s'),
                        'completed_at' => now()
                    ]);

                    $mot->mot_task()->create([
                        'tasks' => $item['mot_comment'],
                        'mot_status' => $item['mot_result'] === 'PASSED' ? 'pass' : 'fail',
                        'dangerous' => [],
                        'majors' => [],
                        'minors' => [],
                        'advisories' => []
                    ]);
                }
            }
        }
        // saving mots record
        Mail::to($request->user())->send(new NewCarCreated($car));

        return redirect()->route('garage.index')->with('success', trans('car.new_car_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CarInfo $garage)
    {
        // ->take(3)
        $garage->loadCount(['mots', 'services', 'repairs']);
        $garage->load(['mots' => fn ($q) => $q->latest()->get(), 'services' => fn ($q) => $q->latest()->get(), 'repairs' => fn ($q) => $q->latest()->get()]);

        $garage_query = MotAppointment::where('car_id', $garage->id);
        $data['mot_completed'] = $garage_query->where('status', 'completed')->count();
        $data['pass_mots'] = $garage_query->whereRelation('mot_task', 'mot_status', 'pass')->count();
        $data['fail_mots'] = MotAppointment::where('car_id', $garage->id)->whereRelation('mot_task', 'mot_status', 'fail')->count();

        // dd($data);
        // dd(now()->diff($garage->last_service_date->addYear()->addMonth()));
        return view('garage.show', compact('garage', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CarInfo $garage)
    {
        return view('garage.edit', compact('garage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GarageRequest $request, CarInfo $garage)
    {
        $data = $request->validated();

        if ($request->image) {
            $this->deleteFile($request->image);
            $data['image'] = $this->fileUpload($request->image);
        }

        $garage->update($data);

        return redirect()->back()->with('success', trans('car.car_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarInfo $garage)
    {
        $this->deleteFile($garage->image);
        $garage->delete();

        return redirect()->route('garage.index')->with('success', trans('car.car_deleted'));
    }
}
