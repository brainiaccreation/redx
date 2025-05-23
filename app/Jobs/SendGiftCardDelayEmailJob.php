<?php

namespace App\Jobs;

use App\Mail\GiftCardDelayMail;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendGiftCardDelayEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order_item;

    public function __construct(OrderItem $order_item)
    {
        $this->order_item = $order_item;
    }

    public function handle()
    {
        $orderItem = $this->order_item;
        $user = $orderItem->order->order_detail;
        $data = [
            'user' => ucfirst($user->name) . ' ' . ucfirst($user->last_name),
            'logo' => url('admin/assets/images/logo-light.png'),
        ];

        Mail::to($user->email)->send(new GiftCardDelayMail($data));

        $this->order_item->update(['is_code_emailed' => true]);
    }
}
