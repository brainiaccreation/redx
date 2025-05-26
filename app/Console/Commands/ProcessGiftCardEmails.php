<?php

namespace App\Console\Commands;

use App\Models\OrderItem;
use Illuminate\Console\Command;
use App\Jobs\SendGiftCardCodeEmailJob;
use Illuminate\Support\Facades\Log;

class ProcessGiftCardEmails extends Command
{
    protected $signature = 'giftcard:send-emails';
    protected $description = 'Send gift card code emails to customers for completed orders';

    public function handle()
    {
        $order_items = OrderItem::where('delivery_status', 'code_assigned')
            ->where('is_code_emailed', false)
            ->with(['giftCardCode', 'product', 'variant'])
            ->get();
        foreach ($order_items as $order_item) {

            dispatch(new SendGiftCardCodeEmailJob($order_item));
        }

        $this->info("Dispatched " . $order_items->count() . " email(s).");
    }
}
