<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderHistory;
use App\Models\Payment;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class OrderController extends Controller
{
   public function checkout()
    {
        $cartItems = auth()->user()->cartItems()->with('product', 'product_variant')->get();
        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        return view('front.checkout', compact('cartItems', 'total'));
    }
    public function processCheckout(Request $request)
    {
        $payment_mode = $request->payment_mode;
        $user = auth()->user();
        $cartItems = $user->cartItems()->with('product', 'product_variant')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        // Calculate total amount
        $totalAmount = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        if($payment_mode == "paydibs"){
            // Paydibs configuration (replace with your actual Paydibs credentials)
            $paydibsConfig = [
                'merchant_id' => config('paydibs.merchant_id'),
                'merchant_password' => config('paydibs.merchant_password'),
                'payment_url' => config('paydibs.payment_url'),
                'return_url' => config('paydibs.return_url'),
                'callback_url' => config('paydibs.callback_url'),
            ];

            // Generate unique IDs
            $merchantPymtID = 'PYM-' . strtoupper(uniqid());
            $merchantOrdID = 'ORD-' . strtoupper(uniqid());

            // Prepare Paydibs PAY request data
            $paydibsData = [
                'TxnType' => 'PAY',
                'MerchantID' => $paydibsConfig['merchant_id'],
                'MerchantPymtID' => $merchantPymtID,
                'MerchantOrdID' => $merchantOrdID,
                'MerchantOrdDesc' => 'Order payment for ' . $user->name.' '.$user->last_name,
                'MerchantTxnAmt' => number_format($totalAmount, 2, '.', ''),
                'MerchantCurrCode' => 'MYR', 
                'MerchantRURL' => str_replace('&', ';', $paydibsConfig['return_url']),
                'CustIP' => $request->ip(),
                'CustName' => $user->name ?? 'Customer',
                'CustEmail' => $user->email ?? 'customer@example.com',
                'CustPhone' => $user->phone ?? '60123456789',
                'MerchantCallbackURL' => str_replace('&', ';', $paydibsConfig['callback_url']),
                'MerchantName' => config('app.name'),
                'PageTimeout' => '300',
            ];

            // Generate Sign
            $sourceString = $paydibsConfig['merchant_password'] .
                            $paydibsData['TxnType'] .
                            $paydibsData['MerchantID'] .
                            $paydibsData['MerchantPymtID'] .
                            $paydibsData['MerchantOrdID'] .
                            $paydibsData['MerchantRURL'] .
                            $paydibsData['MerchantTxnAmt'] .
                            $paydibsData['MerchantCurrCode'] .
                            $paydibsData['CustIP'] .
                            $paydibsData['PageTimeout'] .
                            $paydibsData['MerchantCallbackURL'];

            $paydibsData['Sign'] = hash('sha512', $sourceString);

            // Store temporary checkout data in session to use after payment confirmation
            session([
                'paydibs_checkout_data' => [
                    'cart_items' => $cartItems->toArray(),
                    'total_amount' => $totalAmount,
                    'merchant_pymt_id' => $merchantPymtID,
                    'merchant_ord_id' => $merchantOrdID,
                    'payment_method' => $request->payment_method,
                ]
            ]);

            // Generate Paydibs payment form
            $form = '<form name="frmPaydibs" method="post" action="' . $paydibsConfig['payment_url'] . '">';
            foreach ($paydibsData as $key => $value) {
                $form .= '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars($value) . '">';
            }
            $form .= '<input type="submit" value="Pay Now" style="display:none;">';
            $form .= '</form>';
            $form .= '<script>document.frmPaydibs.submit();</script>';
        }

        if($payment_mode == "stripe"){
            return $this->stripeCheckout($totalAmount,$cartItems,$request);
        }
        return $form;
    }


    private function stripeCheckout($totalAmount,$cartItems,$request) {
        Stripe::setApiKey(config('stripe.key'));

        $lineItems = $cartItems->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => $item->price * 100, 
                ],
                'quantity' => $item->quantity,
            ];
        })->toArray();

        $merchantOrdID = 'ORD-' . strtoupper(uniqid());

        session([
            'checkout_data' => [
                'cart_items' => $cartItems->toArray(),
                'total_amount' => $totalAmount, 
                'merchant_ord_id' => $merchantOrdID,
                'payment_method' => $request->payment_method,
                // 'user_first_name' => $request->user_first_name,
                'country' => $request->country,
                'address' => $request->address,
                'address2' => $request->address2,
                'towncity' => $request->towncity,
                'phone' => $request->phone,
                'email' => $request->email,
            ]
        ]);

        try {
            $session = Session::create([
                // 'payment_method_types' => [$request->payment_method],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('front.cart'),
                'customer_email' => $request->email,
                'billing_address_collection' => 'required',
                'metadata' => [
                    'merchant_ord_id' => $merchantOrdID,
                ],
            ]);
            return redirect()->to($session->url);
            return response()->json(['sessionId' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create checkout session: ' . $e->getMessage()], 500);
        }
    }

    public function handlePaymentReturn(Request $request)
    {
        // Verify payment response
        $paydibsConfig = [
            'merchant_id' => config('paydibs.merchant_id'),
            'merchant_password' => config('paydibs.merchant_password'),
        ];

        $responseData = $request->all();
        $expectedFields = [
            'MerchantID',
            'MerchantPymtID',
            'PTxnID',
            'MerchantOrdID',
            'MerchantTxnAmt',
            'MerchantCurrCode',
            'PTxnStatus',
            'AuthCode',
            'Sign',
        ];

        // Validate response
        foreach ($expectedFields as $field) {
            if (!isset($responseData[$field])) {
                return redirect()->route('front.cart')->with('error', 'Invalid payment response from Paydibs.');
            }
        }

        // Verify Sign
        $sourceString = $paydibsConfig['merchant_password'] .
                        $responseData['MerchantID'] .
                        $responseData['MerchantPymtID'] .
                        $responseData['PTxnID'] .
                        $responseData['MerchantOrdID'] .
                        $responseData['MerchantTxnAmt'] .
                        $responseData['MerchantCurrCode'] .
                        $responseData['PTxnStatus'] .
                        $responseData['AuthCode'];

        $expectedSign = hash('sha512', $sourceString);

        if ($expectedSign !== $responseData['Sign']) {
            return redirect()->route('front.cart')->with('error', 'Invalid payment signature from Paydibs.');
        }

        // Check if payment was successful (PTxnStatus '0' indicates success)
        if ($responseData['PTxnStatus'] !== '0') {
            return redirect()->route('front.cart')->with('error', 'Payment failed with status: ' . $responseData['PTxnStatus']);
        }

        // Retrieve checkout data from session
        $checkoutData = session('paydibs_checkout_data');
        if (!$checkoutData || $checkoutData['merchant_pymt_id'] !== $responseData['MerchantPymtID']) {
            return redirect()->route('front.cart')->with('error', 'Invalid checkout session data.');
        }

        // Start database transaction
        DB::beginTransaction();

        try {
            $user = auth()->user();
            $cartItems = collect($checkoutData['cart_items']);
            $totalAmount = $checkoutData['total_amount'];

            // Create order
            $order = Order::create([
                'unique_id' => $this->generateUniqueOrderId(),
                'order_number' => $checkoutData['merchant_ord_id'],
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'payment_method' => 'paydibs',
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['variant_id'],
                    'game_id' => $item['game_user_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'delivery_method' => 'manual',
                ]);
            }

            // Create order history
            OrderHistory::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'status' => 'completed',
                'notes' => 'Order completed after successful Paydibs payment',
            ]);

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'payment_gateway' => 'paydibs',
                'status' => 'completed',
                'transaction_id' => $responseData['PTxnID'],
                'auth_code' => $responseData['AuthCode'],
            ]);

            // Clear cart
            $user->cartItems()->delete();

            // Clear session data
            session()->forget('paydibs_checkout_data');

            DB::commit();

            return redirect()->route('front.home')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('front.cart')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function handlePaymentCallback(Request $request)
    {
        // Similar to handlePaymentReturn but for server-to-server callback
        $paydibsConfig = [
            'merchant_id' => config('paydibs.merchant_id'),
            'merchant_password' => config('paydibs.merchant_password'),
        ];

        $responseData = $request->all();
        $expectedFields = [
            'MerchantID',
            'MerchantPymtID',
            'PTxnID',
            'MerchantOrdID',
            'MerchantTxnAmt',
            'MerchantCurrCode',
            'PTxnStatus',
            'AuthCode',
            'Sign',
        ];

        // Validate response
        foreach ($expectedFields as $field) {
            if (!isset($responseData[$field])) {
                return response()->json(['status' => 'error'], 400);
            }
        }

        // Verify Sign
        $sourceString = $paydibsConfig['merchant_password'] .
                        $responseData['MerchantID'] .
                        $responseData['MerchantPymtID'] .
                        $responseData['PTxnID'] .
                        $responseData['MerchantOrdID'] .
                        $responseData['MerchantTxnAmt'] .
                        $responseData['MerchantCurrCode'] .
                        $responseData['PTxnStatus'] .
                        $responseData['AuthCode'];

        $expectedSign = hash('sha512', $sourceString);

        if ($expectedSign !== $responseData['Sign']) {
            return response()->json(['status' => 'invalid_signature'], 400);
        }

        // Check if payment was successful
        if ($responseData['PTxnStatus'] === '0') {
            // Process order creation if not already processed
            // This is a fallback in case handlePaymentReturn was not triggered
            $checkoutData = session('paydibs_checkout_data');
            if ($checkoutData && $checkoutData['merchant_pymt_id'] === $responseData['MerchantPymtID']) {
                $user = auth()->user();
                $cartItems = collect($checkoutData['cart_items']);
                $totalAmount = $checkoutData['total_amount'];

                DB::beginTransaction();
                try {
                    $order = Order::firstOrCreate(
                        ['order_number' => $checkoutData['merchant_ord_id']],
                        [
                            'unique_id' => $this->generateUniqueOrderId(),
                            'user_id' => $user->id,
                            'total_amount' => $totalAmount,
                            'payment_method' => 'paydibs',
                            'status' => 'pending',
                        ]
                    );

                    if ($order->wasRecentlyCreated) {
                        foreach ($cartItems as $item) {
                            OrderItem::create([
                                'order_id' => $order->id,
                                'product_id' => $item['product_id'],
                                'product_variant_id' => $item['variant_id'],
                                'game_id' => $item['game_user_id'],
                                'quantity' => $item['quantity'],
                                'price' => $item['price'],
                                'delivery_method' => 'manual',
                            ]);
                        }

                        OrderHistory::create([
                            'order_id' => $order->id,
                            'user_id' => $user->id,
                            'status' => 'completed',
                            'notes' => 'Order completed via Paydibs callback',
                        ]);

                        Payment::create([
                            'order_id' => $order->id,
                            'amount' => $totalAmount,
                            'payment_gateway' => 'paydibs',
                            'status' => 'completed',
                            'transaction_id' => $responseData['PTxnID'],
                            'auth_code' => $responseData['AuthCode'],
                        ]);

                        $user->cartItems()->delete();
                        session()->forget('paydibs_checkout_data');
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['status' => 'error'], 500);
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function handlePaymentSuccess(Request $request)
    {
        Stripe::setApiKey(config('stripe.secret'));

        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return redirect()->route('front.cart')->with('error', 'Invalid payment session.');
        }

        try {
            $session = Session::retrieve($sessionId);
            if ($session->payment_status !== 'paid') {
                return redirect()->route('front.cart')->with('error', 'Payment not completed.');
            }

            $checkoutData = session('checkout_data');
            if (!$checkoutData || $checkoutData['merchant_ord_id'] !== $session->metadata->merchant_ord_id) {
                return redirect()->route('front.cart')->with('error', 'Invalid checkout session data.');
            }

            DB::beginTransaction();

            $user = auth()->user();
            $cartItems = collect($checkoutData['cart_items']);
            $totalAmount = $checkoutData['total_amount'];

            if ($user) {
                $user->update([
                    // 'name' => $checkoutData['user_first_name'],
                    'country' => $checkoutData['country'],
                    'address' => $checkoutData['address'],
                    'address2' => $checkoutData['address2'],
                    'towncity' => $checkoutData['towncity'],
                    'phone' => $checkoutData['phone'],
                    'email' => $checkoutData['email'],
                ]);
            }

            $order = Order::create([
                'unique_id' => $this->generateUniqueOrderId(),
                'order_number' => $checkoutData['merchant_ord_id'],
                'user_id' => $user ? $user->id : null,
                'total_amount' => $totalAmount,
                'payment_method' => 'stripe',
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['variant_id'],
                    'game_id' => $item['game_user_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'delivery_method' => 'manual',
                ]);
            }

            OrderHistory::create([
                'order_id' => $order->id,
                'user_id' => $user ? $user->id : null,
                'status' => 'completed',
                'notes' => 'Order completed after successful Stripe payment',
            ]);

            Payment::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'payment_gateway' => 'stripe',
                'status' => 'completed',
                'transaction_id' => $session->payment_intent,
            ]);

            if ($user) {
                $user->cartItems()->delete();
            }
            session()->forget('checkout_data');

            DB::commit();

            return redirect()->route('front.home')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('front.cart')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(config('stripe.secret'));
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\Exception $e) {
            return response()->json(['status' => 'invalid_signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            if ($session->payment_status === 'paid') {
                $checkoutData = session('checkout_data');
                if ($checkoutData && $checkoutData['merchant_ord_id'] === $session->metadata->merchant_ord_id) {
                    DB::beginTransaction();
                    try {
                        $user = auth()->user();
                        $cartItems = collect($checkoutData['cart_items']);
                        $totalAmount = $checkoutData['total_amount'];

                        if ($user) {
                            $user->update([
                                // 'name' => $checkoutData['user_first_name'],
                                'country' => $checkoutData['country'],
                                'address' => $checkoutData['address'],
                                'address2' => $checkoutData['address2'],
                                'towncity' => $checkoutData['towncity'],
                                'phone' => $checkoutData['phone'],
                                'email' => $checkoutData['email'],
                            ]);
                        }

                        $order = Order::firstOrCreate(
                            ['order_number' => $checkoutData['merchant_ord_id']],
                            [
                                'unique_id' => $this->generateUniqueOrderId(),
                                'user_id' => $user ? $user->id : null,
                                'total_amount' => $totalAmount,
                                'payment_method' => 'stripe',
                                'status' => 'pending',
                            ]
                        );

                        // if ($order->wasRecentlyCreated) {
                            foreach ($cartItems as $item) {
                                OrderItem::create([
                                    'order_id' => $order->id,
                                    'product_id' => $item['product_id'],
                                    'product_variant_id' => $item['variant_id'],
                                    'game_id' => $item['game_user_id'],
                                    'quantity' => $item['quantity'],
                                    'price' => $item['price'],
                                    'delivery_method' => 'manual',
                                ]);
                            }

                            OrderHistory::create([
                                'order_id' => $order->id,
                                'user_id' => $user ? $user->id : null,
                                'status' => 'completed',
                                'notes' => 'Order completed via Stripe webhook',
                            ]);

                            Payment::create([
                                'order_id' => $order->id,
                                'amount' => $totalAmount,
                                'payment_gateway' => 'stripe',
                                'status' => 'completed',
                                'transaction_id' => $session->payment_intent,
                            ]);

                            if ($user) {
                                $user->cartItems()->delete();
                            }
                            session()->forget('checkout_data');
                        // }

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['status' => 'error'], 500);
                    }
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    private function generateUniqueOrderId($length = 8)
    {
        do {
            $id = Str::random($length);
        } while (Order::where('unique_id', $id)->exists());

        return $id;
    }
}
