<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DownloadHistory extends Mailable
{
    use Queueable, SerializesModels;
    public $car, $pdf;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($car, $pdf = null)
    {
        $this->car = $car;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@smartgenix.co.uk', support_setting('app_name'))
            ->subject('Vehicle History - ' . $this->car->name . ' ' . $this->car->reg)
            ->view('mails.downlaod-history', [
                'car' => $this->car,
                'user' => $this->car->user,
            ])
            ->attach(public_path() . '/storage/pdf/' . $this->car->name . '.pdf');
    }
}
