<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoveryQuoteReceived extends Mailable
{
    use Queueable, SerializesModels;
    public $quote;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($quote)
    {
        $this->quote = $quote;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $car = $this->quote?->recovery?->car;
        return $this->from('no-reply@smartgenix.co.uk', support_setting('app_name'))
            ->subject($car->name . ' Recovery Quote Received')
            ->view('mails.recovery-quote', [
                'quote' => $this->quote,
                'recovery' => $this->quote?->recovery,
                'car' => $car,
                'user' => $this->quote?->recovery->user,
            ]);
    }
}
