<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Refund;

class RefundController extends Controller
{
    public function initiate(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'refund_method' => 'required|in:Wallet,Stripe,Paydibs',
        ]);

        $order = Order::with('payment')->findOrFail($request->order_id);
        if ($order->refund_status !== 'Not Requested') {
            return response()->json(['error' => 'Refund already processed or in progress.'], 400);
        }

        try {
            DB::beginTransaction();

            if ($request->refund_method === 'Wallet') {
                $this->processWalletRefund($order);
            } elseif ($request->refund_method === 'Stripe') {
                $this->processStripeRefund($order);
            } else {
                $order->refund_status = 'Requested via Paydibs';
            }

            $order->status = 'refunded';
            $order->save();

            DB::commit();

            return response()->json(['success' => 'Refund processed via ' . $request->refund_method]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Refund failed: ' . $e->getMessage()], 500);
        }
    }

    private function processWalletRefund($order)
    {
        $wallet = Wallet::firstOrCreate(['user_id' => $order->user_id]);
        $wallet->balance += $order->total_amount;
        $wallet->save();

        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'amount' => $order->total_amount,
            'payment_method' => 'wallet',
            'type' => 'credit',
            'description' => 'Refund for Order #' . $order->order_number,
        ]);

        $order->refund_status = 'Refunded to Wallet';

        $user = User::find($order->user_id);
        $user->wallet_balance += $order->total_amount;
        $user->save();
    }

    private function processStripeRefund($order)
    {
        Stripe::setApiKey(config('stripe.secret'));

        $paymentId = $order->payment->transaction_id ?? null;

        if (!$paymentId) {
            throw new \Exception('Stripe Payment ID not found.');
        }

        $refund = \Stripe\Refund::create([
            'payment_intent' => $paymentId,
            'amount' => $order->total_amount * 100,
        ]);

        $order->refund_status = 'Refunded via Stripe';

        $wallet = Wallet::firstOrCreate(['user_id' => $order->user_id]);
        $wallet->balance += $order->total_amount;
        $wallet->save();

        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'amount' => $order->total_amount,
            'payment_method' => 'stripe',
            'type' => 'credit',
            'description' => 'Refund via Stripe for Order #' . $order->order_number,
        ]);
    }
}
