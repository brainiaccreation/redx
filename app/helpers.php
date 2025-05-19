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
if (!function_exists('product_price_range')) {
    function product_price_range($product){

        $prices = $product->variants->pluck('price');
        if ($prices->isEmpty()) return 'N/A';
        $min = number_format($prices->min(), 2);
        $max = number_format($prices->max(), 2);
        return $min === $max ? config('app.currency')." $min" : config('app.currency')." $min - $max";
    }
}