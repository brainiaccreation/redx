<?php

namespace App\Jobs;

use App\Mail\GiftCardCodeMail;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SendGiftCardCodeEmailJob implements ShouldQueue
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
        $code = $orderItem->giftCardCode;
        $order = $orderItem->order;
        $data = [
            'order_no' => $order->order_number,
            'product' => $orderItem->product->name . ' - ' . $orderItem->variant->name,
            'order_date' => runTimeDateFormat($order->created_at),
            'code' => $code->code,
            'user' => ucfirst($user->name) . ' ' . ucfirst($user->last_name),
            'logo' => url('admin/assets/images/logo-light.png'),
        ];

        Mail::to($user->email)->send(new GiftCardCodeMail($data));

        $this->order_item->update(['is_code_emailed' => true]);
    }
}
