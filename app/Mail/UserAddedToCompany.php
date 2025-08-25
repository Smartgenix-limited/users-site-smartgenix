<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAddedToCompany extends Mailable
{
    use Queueable, SerializesModels;

    public $garage, $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($garage, $user)
    {
        $this->garage = $garage;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@smartgenix.co.uk', support_setting('app_name'))
            ->subject('User added to your company')
            ->view('mails.user-added', [
                'garage' => $this->garage,
                'user' => $this->user,
            ]);
    }
}
