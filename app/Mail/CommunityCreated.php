<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommunityCreated extends Mailable
{
    use Queueable, SerializesModels;
    public $community;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($community)
    {
        $this->community = $community;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@smartgenix.co.uk', support_setting('app_name'))
            ->subject('New Thread Created in Smartgenix Community')
            ->view('mails.community-created', [
                'community' => $this->community,
                'user' => $this->community->user,
            ]);
    }
}
