<?php
if (!function_exists('usernameAvatar')) {
    function usernameAvatar($name)
    {
        $nameSplitted = explode(' ', $name);

        $firstLetter = substr($nameSplitted[0], 0, 1);
        if (count($nameSplitted) == 1) {
            $secondLetter = substr($nameSplitted[0], 1, 1);
        } else {
            $secondLetter = substr($nameSplitted[(count($nameSplitted) - 1)], 0, 1);
        }

        return utf8_encode(strtoupper($firstLetter) . strtoupper($secondLetter));
    }
}
if (!function_exists('greetings')) {
    function greetings()
    {
        $now = \Carbon\Carbon::now();
        $time = $now->format('g:i A');

        $greetings = "";
        if ($time < "12:00 PM") {
            $greetings = "Good Morning";
        } else

        if ($time >= "12:00 PM" && $time < "5:00 PM") {
            $greetings = "Good Afternoon";
        } else

        if ($time >= "5:00 PM" && $time < "7:00 PM") {
            $greetings = "Good Evening";
        } else

        if ($time >= "7:00 PM") {
            $greetings = "Good Night";
        }
        return $greetings;
    }
}
if (!function_exists('getCartCount')) {
    function getCartCount()
    {
        if (Auth::check()) {
            return App\Models\Cart::where('user_id', Auth::id())->count();
        } else {
            return session('cart') ? count(session('cart')) : 0;
        }
    }
}
if (!function_exists('topBarCarts')) {
    function topBarCarts()
    {
        $total = 0;
        if (Auth::check()) {
            $cartItems = App\Models\Cart::where('user_id', Auth::id())->get();
        } else {
            $cartItems = session('cart', []);
        }

        return $cartItems ?? null;
    }
}



if (!function_exists('runTimeDateFormat')) {
    function runTimeDateFormat($date)
    {
        return \Carbon\Carbon::parse($date)->format('d M, Y h:i A');
    }
}
if (!function_exists('walletAmountClass')) {

    function walletAmountClass($wallet)
    {
        $class = '';

        if ($wallet->status === 'pending') {
            $class = 'amount-dark';
        } elseif ($wallet->status === 'rejected') {
            $class = 'amount-negative';
        } elseif ($wallet->status === 'approved') {
            $class = $wallet->type === 'credit' ? 'amount-positive' : 'amount-negative';
        }
        return $class;
    }
}

if (!function_exists('product_price_range')) {
    function product_price_range($product)
    {
        $prices = $product->variants->pluck('price');
        if ($prices->isEmpty()) return 'N/A';

        $user = auth()->user();
        $isReseller = $user && $user->account_type === 'reseller';

        $min = $prices->min();
        $max = $prices->max();

        if ($isReseller) {
            $min = round($min * 0.99, 2);
            $max = round($max * 0.99, 2);
        }

        $minFormatted = number_format($min, 2);
        $maxFormatted = number_format($max, 2);

        return $minFormatted === $maxFormatted
            ? config('app.currency') . " $minFormatted"
            : config('app.currency') . " $minFormatted - $maxFormatted";
    }
}


if (!function_exists('normal_product_price_range')) {
    function normal_product_price_range($product)
    {

        $prices = $product->variants->pluck('price');
        if ($prices->isEmpty()) return 'N/A';
        $min = number_format($prices->min(), 2);
        $max = number_format($prices->max(), 2);
        return $min === $max ? " $min" : " $min - $max";
    }
}


if (!function_exists('calculatedPrice')) {
    function calculatedPrice($price)
    {
        if (!$price) return 'N/A';

        $user = auth()->user();
        $isReseller = $user && $user->account_type === 'reseller';


        if ($isReseller) {
            $price = round($price * 0.99, 2);
        }


        return $price;
    }
}
