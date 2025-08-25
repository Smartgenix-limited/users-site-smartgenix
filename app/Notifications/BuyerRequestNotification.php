<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class BuyerRequestNotification extends Notification
{
    use Queueable;
    public $user_name, $market;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_name, $market)
    {
        $this->user_name = $user_name;
        $this->market = $market;
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
            ->subject('Your product has buyer')
            ->greeting('Dear ' . $this->user_name)
            ->line('Your product ' . $this->market->title . ' has a buyer.')
            ->line('To view more information on this offer, log in to our application or visit our website.')
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
