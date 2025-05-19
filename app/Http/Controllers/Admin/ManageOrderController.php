<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Yajra\DataTables\Facades\DataTables;
class ManageOrderController extends Controller
{
    public function list() {
        return view('admin.orders.list');
    }
    public function get(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with(['user']);

            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('order_id', function ($order) {
                    return '<a href="javascript:void(0);">'.$order->order_number.'</a>';

                })
                ->addColumn('customer', function ($order) {
                    return $order->user ? $order->user->name : 'N/A';
                })
                ->addColumn('order_date', function ($order) {
                    return \Carbon\Carbon::parse($order->created_at)->format('d M, Y h:i A');
                })
                ->addColumn('status', function ($order) {
                    return ucfirst($order->status);
                })
                ->addColumn('payment_method', function ($order) {
                    return ucfirst($order->payment_method);
                })
                ->addColumn('total_amount', function ($order) {
                    return number_format($order->total_amount,2);
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



                ->rawColumns(['order_id', 'customer', 'order_date', 'total_amount', 'payment_method', 'status', 'action'])
                ->make(true);
        }
    }

    public function detail($unique_id) {
        $order = Order::where('unique_id',$unique_id)->first();
        if($order){
            $order_items = OrderItem::where('order_id',$order->id)->get();
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
        return view('admin.orders.detail',compact('order','order_items','badgeClass','status'));
    }

    public function status($id, Request $request) {
        $order = Order::find($id);
        if($order->status === $request->status){
            return redirect()->back();
        }
        if($order){
            $order->status = $request->status;
            $order->update();
        }
            return redirect()->back()->with('success','Request has been completed.');
        
    }
}
