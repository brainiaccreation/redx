<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class WalletController extends Controller
{
    public function topUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:bank,stripe,paydibs',
            'receipt_image' => [
                'required_if:payment_method,bank',
                'nullable',
                'image',
                'mimes:jpeg,jpg,png',
                'max:10240', // 10MB
            ],
        ]);

        $user = auth()->user();

        switch ($request->payment_method) {
            case 'bank':
                return $this->handleBankTransfer($request, $user);

            case 'stripe':
                return $this->handleStripeTopUp($request, $user);

            case 'paydibs':
                return $this->handlePaydibsTopUp($request, $user);

            default:
                return back()->with('error', 'Invalid payment method selected.');
        }
    }

    private function handleBankTransfer(Request $request, $user)
    {
        $wallet = $user->wallet ?? Wallet::create(['user_id' => $user->id, 'balance' => 0]);

        if ($request->hasFile('receipt_image')) {
            $receipt_image = $request->file('receipt_image');
            $filename = Str::slug($user->name) . '_receipt_' . time() . '.' . $receipt_image->getClientOriginalExtension();
            $path = public_path('wallet/receipts/');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            if ($user->receipt_image && File::exists(public_path($user->receipt_image))) {
                File::delete(public_path($user->receipt_image));
            }

            $receipt_image->move($path, $filename);
            $wallet->receipt_image = 'wallet/receipts/' . $filename;
        }

        $wallet->transactions()->create([
            'type' => 'credit',
            'amount' => $request->amount,
            'payment_method' => 'bank',
            'receipt_image' => $wallet->receipt_image ?? null,
            'description' => 'Top-up via bank',
            'status' => 'pending',
        ]);

        return back()->with('success', 'Top-up submitted successfully. Please wait for admin approval.');
    }
    // stripe topup api
    private function handleStripeTopUp(Request $request, $user)
    {
        try {
            \Stripe\Stripe::setApiKey(config('stripe.secret'));

            $checkout = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'myr',
                        'product_data' => [
                            'name' => 'Wallet Top-up',
                        ],
                        'unit_amount' => $request->amount * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('wallet.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('myaccount'),
            ]);

            return redirect($checkout->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Stripe Error: ' . $e->getMessage());
        }
    }
    // paydibs topup api
    private function handlePaydibsTopUp(Request $request, $user)
    {
        try {
            $amount = $request->amount;

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
                'MerchantOrdDesc' => 'Wallet Top-up',
                'MerchantTxnAmt' => number_format($amount, 2, '.', ''),
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


            // Generate Paydibs payment form
            $form = '<form name="frmPaydibs" method="post" action="' . $paydibsConfig['payment_url'] . '">';
            foreach ($paydibsData as $key => $value) {
                $form .= '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars($value) . '">';
            }
            $form .= '<input type="submit" value="Pay Now" style="display:none;">';
            $form .= '</form>';
            $form .= '<script>document.frmPaydibs.submit();</script>';

            return $form;
            return redirect()->away($redirectUrl);
        } catch (\Exception $e) {
            return back()->with('error', 'Paydibs Error: ' . $e->getMessage());
        }
    }
    // stripe success
    public function handleStripeSuccess(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.secret'));

        $session_id = $request->get('session_id');
        $session = \Stripe\Checkout\Session::retrieve($session_id);

        $amount = $session->amount_total / 100;
        $user = auth()->user();

        $wallet = $user->wallet ?? Wallet::create(['user_id' => $user->id, 'balance' => $amount]);

        $wallet->balance += $amount;
        $wallet->save();

        $user->wallet_balance += $amount;
        $user->save();
        if ($user->wallet_balance >= 10000 && $user->account_type !== 'reseller') {
            $user->account_type = 'reseller';
            $user->save();
        }
        $wallet->transactions()->create([
            'type' => 'credit',
            'amount' => $amount,
            'payment_method' => 'stripe',
            'description' => 'Top-up via Stripe',
            'status' => 'approved',
        ]);

        return redirect()->route('myaccount')->with('success', 'Wallet topped up successfully!');
    }
    // paydibs succdes
    public function handlePaydibsSuccess(Request $request)
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
                return redirect()->route('myaccount')->with('error', 'Invalid payment response from Paydibs.');
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
            return redirect()->route('myaccount')->with('error', 'Invalid payment signature from Paydibs.');
        }

        // Check if payment was successful (PTxnStatus '0' indicates success)
        if ($responseData['PTxnStatus'] !== '0') {
            return redirect()->route('myaccount')->with('error', 'Payment failed with status: ' . $responseData['PTxnStatus']);
        }

        // Retrieve checkout data from session
        $checkoutData = session('paydibs_checkout_data');
        if (!$checkoutData || $checkoutData['merchant_pymt_id'] !== $responseData['MerchantPymtID']) {
            return redirect()->route('myaccount')->with('error', 'Invalid topup session data.');
        }

        $amount = $request->get('amount');
        $transactionId = $request->get('transaction_id');

        $user = auth()->user();

        $wallet = $user->wallet ?? Wallet::create(['user_id' => $user->id, 'balance' => $amount]);

        $wallet->balance += $amount;
        $wallet->save();

        $user->wallet_balance += $amount;
        $user->save();
        if ($user->wallet_balance >= 10000 && $user->account_type !== 'reseller') {
            $user->account_type = 'reseller';
            $user->save();
        }
        $wallet->transactions()->create([
            'type' => 'credit',
            'amount' => $amount,
            'payment_method' => 'paydibs',
            'description' => 'Top-up via Paydibs',
            'status' => 'approved',
        ]);

        return redirect()->route('myaccount')->with('success', 'Wallet topped up successfully!');
    }

    public function getWalletTransactions(Request $request)
    {

        $userId = Auth::id();

        $query = WalletTransaction::with('wallet')
            ->whereHas('wallet', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        return DataTables::eloquent($query)
            ->addColumn('amount', function ($transaction) {
                return '<span class="' . walletAmountClass($transaction) . '">' . config('app.currency') . ' ' . number_format($transaction->amount, 2) . '</span>';
            })
            ->addColumn('status_badge', function ($transaction) {
                if ($transaction->payment_method === 'bank') {
                    switch ($transaction->status) {
                        case 'pending':
                            return '<span class="badge bg-warning-subtle text-warning">Pending</span>';
                        case 'approved':
                            return '<span class="badge bg-success-subtle text-success">Completed</span>';
                        case 'rejected':
                            return '<span class="badge bg-danger-subtle text-danger">Rejected</span>';
                        default:
                            return '-';
                    }
                }
                return '<span class="badge bg-info-subtle text-success">Completed</span>';
            })
            ->addColumn('created_at_formatted', function ($transaction) {
                return $transaction->created_at->format('d M Y h:i A');
            })
            ->rawColumns(['amount', 'status_badge'])
            ->make(true);
    }
}
