<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $repair, $garage;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($repair, $garage)
    {
        $this->repair = $repair;
        $this->garage = $garage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@smartgenix.co.uk', support_setting('app_name'))
            ->subject('Repair quote accepted')
            ->view('mails.quote-accepted', [
                'repair' => $this->repair,
                'garage' => $this->garage,
                'car' => $this->repair->car,
            ]);
    }
}
