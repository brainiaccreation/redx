<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class AccountController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get();
        return view('front.account', compact('orders'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->update();

        return redirect()->back()->with('success', 'Request has been completed.');
    }

    public function order_detail($unique_id)
    {
        $order = Order::where('unique_id', $unique_id)->first();
        if ($order) {
            $order_items = OrderItem::where('order_id', $order->id)->get();
            $status = $order->status;
            $statusClasses = [
                'pending'    => 'badge bg-warning-subtle text-warning fw-medium',
                'processing' => 'badge bg-info-subtle text-info fw-medium',
                'completed'  => 'badge bg-success-subtle text-success fw-medium',
                'failed'     => 'badge bg-danger-subtle text-danger fw-medium',
                'cancelled'  => 'badge bg-secondary-subtle text-secondary fw-medium',
            ];
            $badgeClass = $statusClasses[$order->status] ?? 'badge bg-primary-subtle text-primary';
        }
        return view('front.order_details', compact('order', 'order_items', 'badgeClass', 'status'));
    }
}
