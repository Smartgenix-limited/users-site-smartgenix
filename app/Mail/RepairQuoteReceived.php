<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RepairQuoteReceived extends Mailable
{
    use Queueable, SerializesModels;
    public $repair;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($repair)
    {
        $this->repair = $repair;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $car = $this->repair?->car;
        return $this->from('no-reply@smartgenix.co.uk', support_setting('app_name'))
            ->subject($car->name . ' Repair Quote Attached')
            ->view('mails.repair-quote', [
                'repair' => $this->repair,
                'car' => $car,
                'user' => $this->repair->user,
            ]);
    }
}
