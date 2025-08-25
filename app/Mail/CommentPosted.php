<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;
    public $community, $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($community, $comment)
    {
        $this->community = $community;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@smartgenix.co.uk', support_setting('app_name'))
            ->subject('New Community Comment Created')
            ->view('mails.comment-posted', [
                'comment' => $this->comment,
                'community' => $this->community,
                'user' => $this->community->user,
            ]);
    }
}
