<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $car, $service, $days;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($car, $service, $days)
    {
        $this->car = $car;
        $this->service = $service;
        $this->days = $days;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@smartgenix.co.uk', support_setting('app_name'))
            ->subject($this->car->name . ' ' . $this->service . ' Reminder')
            ->view('mails.service-reminder', [
                'car' => $this->car,
                'service' => $this->service,
                'user' => $this->car->user,
            ]);
    }
}
