<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CarPickup extends Mailable
{
    use Queueable, SerializesModels;

    public $car, $service;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($car, $service)
    {
        $this->car = $car;
        $this->service = $service;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@smartgenix.co.uk', support_setting('app_name'))
            ->subject($this->car->name . ' ' . $this->service . ' Task Completed')
            ->view('mails.car-pickup', [
                'car' => $this->car,
                'service' => $this->service,
                'user' => $this->car->user,
            ]);
    }
}
