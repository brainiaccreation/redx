<?php

return [
    'key' => env('STRIPE_SECRET_KEY', ''),
    'secret' => env('STRIPE_SECRET_KEY', ''),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', ''),
    'webhook_secret_url' => env('STRIPE_WEBHOOK_SECRET_URL', ''),
];