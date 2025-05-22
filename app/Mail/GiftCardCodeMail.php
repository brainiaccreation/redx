<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GiftCardCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function build()
    {
        $userName = $this->data['user'];
        $orderNo = $this->data['order_no'];

        return $this->subject("Thank You, {$userName}! Your Order #{$orderNo} is Complete")
            ->view('emails.gift_card_code')
            ->with('data', $this->data);
    }
}
