<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get();
        $wallets = Wallet::where('user_id', auth()->user()->id)->with('transaction')->paginate(10);
        return view('front.account', compact('orders', 'wallets'));
    }

    public function update(Request $request, $id)
    {



        $request->validate([
            'name'         => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'email'        => 'required|email|max:150|unique:users,email,' . $id,
            'phone'        => 'nullable|string|max:25',
            'country'      => 'nullable|string|max:100',
            'towncity'     => 'nullable|string|max:100',
            'address'      => 'nullable|string|max:350',
            'address2'     => 'nullable|string|max:350',
            'avatar'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->towncity = $request->towncity;
        $user->address = $request->address;
        $user->address2 = $request->address2;
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
    public function getOrderList(Request $request)
    {

        $userId = Auth::id();

        $query = Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->select('*');
        return DataTables::eloquent($query)
            ->addColumn('order_number', function ($order) {
                return '<div class="cart-item-thumb d-flex align-items-center gap-4">
                            <a href="' . route('user.order.details', $order->unique_id) . '"
                                style="color: #011e5e;"><span
                                    class="text-nowrap">#' . $order->order_number . '</span></a>
                        </div>';
            })
            ->addColumn('payment_method', function ($order) {
                return '<span class="price-usd">
                            ' . ucfirst($order->payment_method) . '
                        </span>';
            })

            ->addColumn('total_amount', function ($order) {
                return '<span class="price-usd">
                            ' . number_format($order->total_amount, 2) . ' ' . config('app.currency') . '
                        </span>';
            })
            ->addColumn('status', function ($order) {
                return ' <span class="price-usd">
                            ' . ucfirst($order->status) . '
                        </span>';
            })
            ->addColumn('refund_status', function ($order) {
                return ' <span class="price-usd">
                            ' . ucfirst($order->refund_status) . '
                        </span>';
            })
            ->addColumn('action', function ($order) {
                $html = '<div style="display: flex; gap: 8px; justify-content: center;">';

                if ($order->refund_status !== 'Not Requested') {
                    $html .= '<span class="text-center">-</span>';
                } else {
                    $html .= '<a href="javascript:void(0);" class="action_btn edit-item open-refund-modal" title="Refund Amount"
                    data-bs-toggle="modal"
                    data-bs-target="#refundModal"
                    data-id="' . $order->id . '"
                    data-order-id="' . $order->order_number . '"
                    data-amount="' . $order->total_amount . '"
                    data-user-id="' . $order->user_id . '">
                    <i class="fa fa-undo" aria-hidden="true"></i>
                </a>';
                }

                $html .= '</div>';

                return $html;
            })

            ->rawColumns(['order_number', 'payment_method', 'total_amount', 'status', 'refund_status', 'action'])
            ->make(true);
    }
}
