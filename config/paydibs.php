<?php

return [
    'merchant_id' => env('PAYDIBS_MERCHANT_ID', ''),
    'merchant_password' => env('PAYDIBS_MERCHANT_PASSWORD', ''),
    'merchant_name' => env('PAYDIBS_MERCHANT_NAME', 'RedX'),
    'payment_url' => env('PAYDIBS_PAYMENT_URL', 'https://paydibs.com/payment'),
    'callback_url' => env('PAYDIBS_CALLBACK_URL', 'https://dev.paydibs.com/PPGSG/PymtCheckout.aspx'),
    'return_url' => env('PAYDIBS_RETURN_URL', 'https://dev.paydibs.com/PPGSG/PymtCheckout.aspx'),
    'currency_code' => env('PAYDIBS_CURRENCY_CODE', 'MYR'),
];