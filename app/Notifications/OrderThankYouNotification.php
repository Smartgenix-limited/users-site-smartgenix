<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OrderThankYouNotification extends Notification
{
    use Queueable;

    public $item;
    public $type;
    public $user_type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($type, $item, $user_type = 'normal')
    {
        $this->type = $type;
        $this->item = $item;
        $this->user_type  = $user_type;
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
        if ($this->type === 'mot') {
            $subject = 'MOT';
            $price = $this->item->price;
        } elseif ($this->type === 'service') {
            $subject = 'Service';
            $price = $this->item->price;
        } else {
            $subject = 'Repair';
            $price = $this->item->price;
        }

        return (new MailMessage)
            ->subject('New ' . $subject)
            ->when(
                $this->user_type === 'admin',
                function (MailMessage $mail) use ($subject) {
                    return $mail->line('You have new ' . $subject . ' Job')
                        ->line($subject . ' due date is following.');
                },
                function (MailMessage $mail) use ($subject) {
                    return $mail->line('Thanks for new order.')
                        ->line('Your ' . $subject . ' due date is following.');
                }
            )
            ->line(new HtmlString("Date: {$this->item->datetime->format('d/m/Y')}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Time:  {$this->item->datetime->format('H:i')}"))
            ->line('The Price for this ' . $subject . ' is ' . support_setting('currency_symbol') . $price . '.')
            ->when(
                $this->user_type === 'admin',
                function (MailMessage $mail) use ($subject) {
                    return $mail->action('View ' . $subject, url('/') . '/admin/' . $this->type . 's/' . $this->item->id);
                }
            );
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
