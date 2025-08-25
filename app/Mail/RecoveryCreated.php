<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoveryCreated extends Mailable
{
    use Queueable, SerializesModels;
    public $recovery;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recovery)
    {
        $this->recovery = $recovery;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $car = $this->recovery?->car;
        return $this->from('no-reply@smartgenix.co.uk', support_setting('app_name'))
            ->subject($car->name . ' Recovery Job Created')
            ->view('mails.recovery-created', [
                'recovery' => $this->recovery,
                'car' => $car,
                'user' => $this->recovery->user,
            ]);
    }
}
