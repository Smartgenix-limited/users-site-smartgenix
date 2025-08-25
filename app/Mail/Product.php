<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Product extends Mailable
{
    use Queueable, SerializesModels;
    public $product, $type, $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($product, $type, $user)
    {
        $this->product = $product;
        $this->type = $type;
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
            ->subject($this->type === 'buying' ? 'Buying' : 'Selling' . ' a product')
            ->view('mails.product', [
                'type' => $this->type,
                'product' => $this->product,
                'user' => $this->user,
            ]);
    }
}
