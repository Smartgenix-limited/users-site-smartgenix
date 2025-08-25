<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceCreated extends Mailable
{
    use Queueable, SerializesModels;
    public $service, $type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($service, $type)
    {
        $this->service = $service;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@smartgenix.co.uk', support_setting('app_name'))
            ->subject($this->type . ' Appointment Created')
            ->view('mails.service-created', [
                'type' => $this->type,
                'service' => $this->service,
                'car' => $this->service?->car,
                'user' => $this->service->user,
            ]);
    }
}
