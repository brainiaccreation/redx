<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $variantId = $request->variant_id;
        $productId = $request->product_id;
        $price = $request->price;
        $quantity = $request->quantity ?? 1;
        if (Auth::check()) {
            Cart::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'variant_id' => $variantId
                ],
                [
                    'product_id' => $productId,
                    'quantity' => DB::raw('quantity + ' . $quantity),
                    'price' => $price
                ]
            );
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$variantId])) {
                $cart[$variantId]['quantity'] += $quantity;
            } else {
                $cart[$variantId] = [
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'quantity' => $quantity,
                    'price' => $price
                ];
            }

            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => $this->getCartCount()
        ]);
    }

    public function getCartCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->count();
        } else {
            return session('cart') ? count(session('cart')) : 0;
        }
    }

    public function showCart()
    {
        $total = 0;
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->get();
        } else {
            $cartItems = session('cart', []);
        }

        return view('front.cart', compact('cartItems','total'));
    }
    public function update(Request $request)
    {
        $item = Cart::where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($item) {
            $item->quantity = $request->quantity;
            $item->save();
        }
        $total = 0;
        $cartItems = Cart::all();
        $cartHtml = view('front.cart', compact('cartItems','total'))->render();

        return response()->json(['cartHtml' => $cartHtml]);
    }
    public function remove(Request $request)
    {
        Cart::where('id', $request->cart_id)->delete();

        $cartItems = Cart::all();
        $total = 0;
        $cartHtml = view('front.cart', compact('cartItems','total'))->render();

        return response()->json(['cartHtml' => $cartHtml]);
    }
    public function checkout(Request $request)
    {
        $cartItems = Cart::where('user_id',auth()->id())->get();
        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $cartItems->sum(fn ($item) => $item->price * $item->quantity)
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->product_variant_id,
                'price' => $item->price,
                'quantity' => $item->quantity,
            ]);
        }

        Cart::truncate();

        return redirect()->route('order.success')->with('success', 'Order placed successfully!');
    }

}
