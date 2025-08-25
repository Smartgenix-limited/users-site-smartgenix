<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GarageRepair extends Mailable
{
    use Queueable, SerializesModels;

    public $garage;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($garage)
    {
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
            ->subject('Repair job created')
            ->view('mails.garage-repair', [
                'garage' => $this->garage,
            ]);
    }
}
