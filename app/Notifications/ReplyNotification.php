<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ReplyNotification extends Notification
{
    use Queueable;
    public $community, $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $community)
    {
        $this->community = $community;
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Community comment Created')
            ->greeting('Dear ' . $this->community->user->name)
            ->line("Your thread has a new comment you may want to see. Here's an overview of the comment:")
            ->line('Title: ' . $this->community->title)
            ->line('Message: ' . $this->comment)
            ->line('Date & Time: ' . now()->format('d F Y h:i A'))
            ->line('You can log onto our application or website and view the comment and reply to the comment. ')
            ->line("If you have any questions or concerns, please don't hesitate to contact us by creating a support ticket or emailing us at queries@smartgenix.co.uk.")
            ->salutation(new HtmlString('<p>Kind regards,</p><b>Smartgenix Support Team</b>'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
