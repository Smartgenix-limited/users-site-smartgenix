<?php

namespace App\Http\Controllers;

use App\Mail\DownloadHistory;
use App\Models\CarHistoryRequest;
use App\Models\CarInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;
use Barryvdh\DomPDF\Facade;
use Illuminate\Support\Facades\Storage;

class CarHistoryController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $history = CarHistoryRequest::create([
            'user_id' => auth()->id(),
            'car_id' => $id,
            'datetime' => now(),
            'status' => 'pending'
        ]);

        return redirect()->route('payment', ['payment_for' => 'history', 'id' => $history->id]);
    }

    /**
     * Download the car history.
     *
     * @return \Illuminate\Http\Response
     */
    public function download(CarHistoryRequest $history)
    {
        if ($history->payment_id) {
            // history has completed payment
            $history->load('car');
            $car = $history->car;
            $car->load(['user', 'mots' => fn ($q) => $q->with('mot_task')->latest('datetime'), 'services' => fn ($q) => $q->with('tasks')->latest('datetime'), 'repairs' => fn ($q) => $q->with('tasks')->whereNotNull('datetime')->latest('datetime'), 'recoveries']);

            $pdf = PDF::loadView('garage.print', compact('car'));

            Storage::put('public/pdf/' . $car?->name . '.pdf', $pdf->output());

            Mail::to(auth()->user())->send(new DownloadHistory($car));

            // return $pdf->download('history.pdf');

            return redirect()->route('garage.show', $history->car->id)->with('success', trans('general.history_send'));
        } else {
            // history payment is not completed. redirect back
            return redirect()->route('payment', ['payment_for' => 'history', 'id' => $history->id])->with('error', trans('general.pay_car_history_fee'));
        }
    }
}
