<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $variantId = $request->variant_id;
        $productId = $request->product_id;
        $price = $request->price;
        $game_user_id = $request->game_user_id;
        $game_server_id = $request->game_server_id;
        $game_user_name = $request->game_user_name;
        $game_email = $request->game_email;
        $quantity = $request->quantity ?? 1;
        if (Auth::check()) {
            Cart::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'variant_id' => $variantId,
                    'game_user_id' => $game_user_id
                ],
                [
                    'product_id' => $productId,
                    'quantity' =>  $quantity,
                    'price' => $price,
                    'game_user_id' => $game_user_id,
                    'game_server_id' => $game_server_id,
                    'game_user_name' => $game_user_name,
                    'game_email' => $game_email,
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
                    'price' => $price,
                    'game_user_id' => $game_user_id,
                    'game_server_id' => $game_server_id,
                    'game_user_name' => $game_user_name,
                    'game_email' => $game_email,
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
        $cartItems = [];
        $total = 0;

        if (Auth::check()) {
            $cartItems = Cart::with(['product', 'product_variant'])
                ->where('user_id', Auth::id())
                ->get();

            foreach ($cartItems as $item) {
                $total += $item->quantity * $item->price;
            }
        } else {
            $sessionCart = session('cart', []);
            foreach ($sessionCart as $variantId => $item) {
                $variant = \App\Models\ProductVariant::with('product')->find($item['variant_id']);

                if ($variant) {
                    $subtotal = $item['quantity'] * $item['price'];
                    $total += $subtotal;

                    $cartItems[] = (object) [
                        'product' => $variant->product,
                        'product_variant' => $variant,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'game_user_id' => $item['game_user_id'],
                        'game_server_id' => $item['game_server_id'],
                        'game_user_name' => $item['game_user_name'],
                        'game_email' => $item['game_email'],
                    ];
                }
            }
        }
        // session()->forget('cart');
        // return $cartItems;
        return view('front.cart', compact('cartItems', 'total'));
    }

    public function update(Request $request)
    {
        foreach ($request->items as $item) {
            if ($item['is_model'] === 'true') {
                $cartItem = \App\Models\Cart::where('product_id', $item['product_id'])
                    ->where('variant_id', $item['variant_id'])
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity = $item['quantity'];
                    $cartItem->save();
                }
            } else {
                $cart = session()->get('cart', []);
                foreach ($cart as &$cartRow) {
                    if ($cartRow['product_id'] == $item['product_id'] && $cartRow['variant_id'] == $item['variant_id']) {
                        $cartRow['quantity'] = $item['quantity'];
                    }
                }
                session()->put('cart', $cart);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully.'
        ]);
    }

    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $variantId = $request->variant_id;
        $isModel = $request->is_model === "true";
        if ($isModel) {
            \App\Models\Cart::where('product_id', $productId)
                ->where('variant_id', $variantId)
                ->where('user_id', auth()->id())
                ->delete();
        } else {
            $cart = session()->get('cart', []);
            foreach ($cart as $key => $item) {
                if ($item['product_id'] == $productId && $item['variant_id'] == $variantId) {
                    unset($cart[$key]);
                    break;
                }
            }
            session()->put('cart', $cart);
        }

        return response()->json(['message' => 'Item removed from cart successfully.']);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'total' => 'required|numeric'
        ]);

        $coupon = Coupon::where('code', strtoupper($request->code))->first();

        if (!$coupon) {
            return response()->json(['error' => 'Invalid coupon code.']);
        }

        if (!$coupon->canBeUsed()) {
            return response()->json(['error' => 'This coupon cannot be used.']);
        }

        if ($request->total < $coupon->min_amount) {
            return response()->json(['error' => 'Minimum amount required for this coupon is ' . number_format($coupon->min_amount, 2)]);
        }

        $discount = $coupon->calculateDiscount($request->total);

        return response()->json([
            'success' => true,
            'coupon_code' => $coupon->code,
            'coupon_id' => $coupon->id,
            'discount' => $discount,
            'formatted' => '-' . number_format($discount, 2),
            'new_total' => round($request->total - $discount, 2),
            'discount_type' => $coupon->type,
            'discount_value' => $coupon->value,
            'description' => $coupon->type === 'percentage' ? $coupon->value . '% OFF' : config('app.currency') . ' ' . $coupon->value . ' OFF' // Optional: Add description from backend
        ]);
    }
    // public function checkout(Request $request)
    // {
    //     $cartItems = Cart::where('user_id',auth()->id())->get();
    //     $order = Order::create([
    //         'user_id' => auth()->id(),
    //         'total' => $cartItems->sum(fn ($item) => $item->price * $item->quantity)
    //     ]);

    //     foreach ($cartItems as $item) {
    //         OrderItem::create([
    //             'order_id' => $order->id,
    //             'product_id' => $item->product_id,
    //             'variant_id' => $item->product_variant_id,
    //             'price' => $item->price,
    //             'quantity' => $item->quantity,
    //         ]);
    //     }

    //     Cart::truncate();

    //     return redirect()->route('order.success')->with('success', 'Order placed successfully!');
    // }


}
