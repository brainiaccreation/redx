<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GiftCardDelayMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }
    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject('Gift Card Delivery Pending')
            ->view('emails.gift_card_delay');
    }
}
