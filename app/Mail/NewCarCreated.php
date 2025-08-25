<?php

namespace App\Mail;

use App\Models\CarInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCarCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var \App\Models\CarInfo
     */
    public $car;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\CarInfo  $car
     * @return void
     */
    public function __construct(CarInfo $car)
    {
        $this->car = $car;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@smartgenix.co.uk', support_setting('app_name'))
            ->subject('New car added')
            ->view('mails.new-car', [
                'car' => $this->car,
                'user' => $this->car->user,
            ]);
    }
}
