<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderHistory;
use Yajra\DataTables\Facades\DataTables;

class ManageOrderController extends Controller
{
    public function list()
    {
        return view('admin.orders.list');
    }
    public function get(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::query()
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select(
                    'orders.id',
                    'orders.unique_id',
                    'orders.order_number',
                    'orders.created_at',
                    'orders.status',
                    'orders.total_amount',
                    'orders.payment_method',
                    'orders.user_id',
                    'users.name as user_name',
                    'users.last_name as user_last_name',
                    'order_details.name as guest_name'
                )

                ->with(['user', 'order_detail']);

            return DataTables::of($orders)
                ->addIndexColumn()

                ->addColumn('order_id', function ($order) {
                    return '<a href="' . route('admin.order.details', $order->unique_id) . '">' . $order->order_number . '</a>';
                })

                ->addColumn('customer', function ($order) {
                    if ($order->user_name || $order->user_last_name) {
                        return '<a href="' . route('admin.user.view', $order->user_id) . '">' . $order->user_name . ' ' . $order->user_last_name . '</a>';
                    } elseif ($order->guest_name) {
                        return $order->guest_name;
                    }
                    return 'N/A';
                })

                ->addColumn('order_date', function ($order) {
                    return runTimeDateFormat($order->created_at);
                })

                ->addColumn('status', function ($order) {
                    $statusClasses = [
                        'pending'    => 'badge bg-warning-subtle text-warning fw-medium',
                        'processing' => 'badge bg-info-subtle text-info fw-medium',
                        'completed'  => 'badge bg-success-subtle text-success fw-medium',
                        'failed'     => 'badge bg-danger-subtle text-danger fw-medium',
                        'cancelled'  => 'badge bg-secondary-subtle text-secondary fw-medium',
                    ];
                    $badgeClass = $statusClasses[$order->status] ?? 'badge bg-primary-subtle text-primary';
                    return '<h5><span class="' . $badgeClass . '">' . ucfirst($order->status) . '</span></h5>';
                })

                ->addColumn('payment_method', function ($order) {
                    return ucfirst($order->payment_method);
                })

                ->addColumn('total_amount', function ($order) {
                    return number_format($order->total_amount, 2);
                })

                ->addColumn('action', function ($order) {
                    return '
                    <div style="display: flex; gap: 8px;">
                        <a href="' . route('admin.order.details', $order->unique_id) . '" class="action_btn edit-item">
                            <i class="ri-eye-line"></i>
                        </a>
                    </div>
                ';
                })

                // FILTERS
                ->filterColumn('customer', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('users.name', 'like', "%{$keyword}%")
                            ->orWhere('users.last_name', 'like', "%{$keyword}%")
                            ->orWhere('order_details.name', 'like', "%{$keyword}%");
                    });
                })

                ->filterColumn('order_id', function ($query, $keyword) {
                    $query->where('orders.order_number', 'like', "%{$keyword}%");
                })

                ->filterColumn('order_date', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->whereDate('orders.created_at', $keyword)
                            ->orWhereRaw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') LIKE ?", ["%{$keyword}%"])
                            ->orWhereRaw("DATE_FORMAT(orders.created_at, '%d-%m-%Y') LIKE ?", ["%{$keyword}%"])
                            ->orWhereRaw("DATE_FORMAT(orders.created_at, '%M') LIKE ?", ["%{$keyword}%"]);
                    });
                })

                ->filterColumn('total_amount', function ($query, $keyword) {
                    $query->where('orders.total_amount', 'like', "%{$keyword}%");
                })

                ->filterColumn('payment_method', function ($query, $keyword) {
                    $query->where('orders.payment_method', 'like', "%{$keyword}%");
                })

                ->filterColumn('status', function ($query, $keyword) {
                    $query->whereRaw("LOWER(orders.status) LIKE ?", ["%" . strtolower($keyword) . "%"]);
                })

                // SORTING
                ->orderColumn('customer', function ($query, $order) {
                    $query->orderByRaw("COALESCE(users.name, order_details.name) {$order}");
                })

                ->orderColumn('order_id', function ($query, $order) {
                    $query->orderBy('orders.order_number', $order);
                })

                ->orderColumn('order_date', function ($query, $order) {
                    $query->orderBy('orders.created_at', $order);
                })

                ->orderColumn('status', function ($query, $order) {
                    $query->orderBy('orders.status', $order);
                })

                ->rawColumns(['order_id', 'customer', 'order_date', 'total_amount', 'payment_method', 'status', 'action'])

                ->make(true);
        }
    }



    public function detail($unique_id)
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
        return view('admin.orders.detail', compact('order', 'order_items', 'badgeClass', 'status'));
    }

    public function status($id, Request $request)
    {
        $order = Order::find($id);
        if ($order->status === $request->status) {
            return redirect()->back();
        }
        if ($order) {
            $order->status = $request->status;
            $order->update();
            $statusMessages = [
                'pending'    => 'Order marked as Pending.',
                'processing' => 'Order is now Processing.',
                'completed'  => 'Order has been Completed.',
                'failed'     => 'Order has Failed.',
                'cancelled'  => 'Order has been Cancelled.',
            ];
            $historyText = $statusMessages[$order->status] ?? 'Order status updated.';
            OrderHistory::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'status' => $order->status,
                'notes' => $historyText,
            ]);
        }
        return redirect()->back()->with('success', 'Request has been completed.');
    }
}
