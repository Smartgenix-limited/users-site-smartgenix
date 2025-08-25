<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\CarHistoryRequest;
use App\Models\MotAppointment;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\RecoveryCompleter;
use App\Models\RepairAppointment;
use App\Models\ServiceAppointment;
use App\Services\UserService;
use Illuminate\Http\Request;
use Stripe;

class PaymentController extends Controller
{
    // payment show form
    public function payment($payment_for = null, $id)
    {
        if ($payment_for !== 'history') {
            $price = $this->for_service($payment_for, $id)->price;
            $purpose = $payment_for;
        } else {
            $price = convert_price(support_setting('download_history_price'));
            $purpose = 'smartgenix';
        }

        return view('payment', compact('payment_for', 'id', 'price', 'purpose'));
    }

    // capture payment
    public function capture_payment(Request $request)
    {
        $service = $this->for_service($request->for, $request->id);
        $trans_id = $this->transaction($request)->id;

        if ($request->for !== 'history') {
            if ($request->for === 'recoveries') {
                $service->recovery()->update([
                    'payment_id' => $trans_id
                ]);
                return redirect()->route($request->for . '.show', $service->recovery->id)->with('success', trans('general.thanks_payment'));
            } else {
                $service->update(['payment' => PaymentStatus::Paid, 'payment_id' => $trans_id]);
                Payment::find($trans_id)->update(['repair_id' => $request->id]);

                return redirect()->route($request->for . '.show', $request->id)->with('success', trans('general.thanks_payment'));
            }
        } else {
            $service->update(['status' => 'completed', 'payment_id' => $trans_id]);
            Payment::find($trans_id)->update(['history_id' => $request->id]);
            return redirect()->route('car.history.download', $request->id);
        }
    }

    /**
     * save transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        return response([
            'transaction' => $this->transaction($request)->id,
            'amount' => $request->amount
        ]);
    }

    // select payment for service basic on condition
    private function for_service($payment_for, $id)
    {
        if ($payment_for === 'mots') {
            $service = MotAppointment::select(['id', 'price'])->find($id);
        } else if ($payment_for === 'services') {
            $service = ServiceAppointment::select(['id', 'price'])->find($id);
        } else if ($payment_for === 'repairs') {
            $service = RepairAppointment::select(['id', 'price'])->find($id);
        } else if ($payment_for === 'recoveries') {
            $service = RecoveryCompleter::with('recovery:id,payment_id')->select(['id', 'recovery_id', 'price'])->find($id);
        } else {
            $service = CarHistoryRequest::select(['id'])->find($id);
        }
        return $service;
    }

    // save transaction
    private function transaction($request)
    {
        // $currency = support_setting('currency_name');
        $convert_price = (float)reconvert_price($request->amount);

        if ($request->type === 'card') {
            // Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            Stripe\Stripe::setApiKey(support_setting('stripe_secret'));
            $payment = Stripe\Charge::create([
                "amount" => $convert_price * 100,
                // "currency" => strtolower($currency),
                "currency" => 'gbp',
                "source" => $request->stripeToken,
                "description" => ""
            ]);
        }
        // creating transaction
        return Payment::create([
            'garage_id' => $request->input('purpose', '') !== 'smartgenix' ? active_garage() : null,
            'user_id' => auth()->id(),
            'type' => $request->type,
            'payment_type' => $request->type,
            'amount' => $convert_price,
            // 'currency' => strtolower($currency),
            'currency' => 'gbp',
            'stripe_id' => $request->type === 'card' ? $payment->id : null,
            'promo_code' => $request->promocode ?? NULL
        ]);
    }

    // apply promo code
    public function promocode(Request $request)
    {
        $today = now()->format('Y-m-d');
        $promo = Notification::where('promocode', $request->code)->whereDate('start_date', '<=', $today)->where('end_date', '>=', $today)->first();

        if (!$promo) {
            return response([
                'success' => false,
                'message' => 'Invalid promo code'
            ]);
        }
        return response([
            'success' => true,
            'message' => trans('general.promo_apply', ['percentage' => $promo->discountAmount]),
            'code' => $request->code,
            'value' => $promo->discountAmount,
        ]);
    }
}
