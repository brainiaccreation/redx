<?php

namespace App\Console\Commands;

use App\Jobs\SendGiftCardDelayEmailJob;
use App\Models\OrderItem;
use Illuminate\Console\Command;

class ProcessGiftCardDelayEmails extends Command
{
    protected $signature = 'giftcarddelay:send-emails';
    protected $description = 'Send gift card delay emails to customers for pending codes orders';

    public function handle()
    {
        $order_items = OrderItem::where('delivery_status', 'pending_code')
            ->where('is_code_emailed', false)
            ->with(['giftCardCode', 'product', 'variant'])
            ->get();
        foreach ($order_items as $order_item) {

            dispatch(new SendGiftCardDelayEmailJob($order_item));
        }

        $this->info('Pending gift card code emails dispatched.');
    }
}
