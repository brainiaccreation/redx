<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesReportController extends Controller
{
    public function index()
    {
        return view('admin.sales.report');
    }

    public function getStats(Request $request)
    {
        if ($request->ajax()) {
            $dateRange = $request->input('date_range');
            $paymentMethod = $request->input('payment_method');
            $status = $request->input('status');
            $customerType = $request->input('customer_type');

            $query = Order::query();

            // Apply date range filter only if provided
            if ($dateRange && is_numeric($dateRange)) {
                $startDate = Carbon::now()->subDays($dateRange);
                $query->where('created_at', '>=', $startDate);
            }

            if ($paymentMethod) {
                $query->where('payment_method', $paymentMethod);
            }

            if ($status) {
                $query->where('status', $status);
            }

            // Get total stats
            $totalSales = $query->sum('total_amount');
            $totalOrders = $query->count();
            $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

            // Get previous period for comparison
            $prevQuery = Order::query();
            if ($dateRange && is_numeric($dateRange)) {
                $startDate = Carbon::now()->subDays($dateRange);
                $prevQuery->whereBetween('created_at', [
                    Carbon::now()->subDays($dateRange * 2),
                    $startDate
                ]);
            }

            if ($paymentMethod) {
                $prevQuery->where('payment_method', $paymentMethod);
            }

            if ($status) {
                $prevQuery->where('status', $status);
            }

            $prevTotalSales = $prevQuery->sum('total_amount');
            $prevTotalOrders = $prevQuery->count();

            $salesChange = $prevTotalSales > 0 ? (($totalSales - $prevTotalSales) / $prevTotalSales) * 100 : 0;
            $ordersChange = $prevTotalOrders > 0 ? (($totalOrders - $prevTotalOrders) / $prevTotalOrders) * 100 : 0;

            return response()->json([
                'total_sales' => number_format($totalSales, 2),
                'total_orders' => number_format($totalOrders),
                'avg_order_value' => number_format($avgOrderValue, 2),
                'sales_change' => round($salesChange, 1),
                'orders_change' => round($ordersChange, 1),
                'sales_today' => number_format(Order::whereDate('created_at', Carbon::today())->sum('total_amount'), 2),
                'orders_today' => Order::whereDate('created_at', Carbon::today())->count()
            ]);
        }
    }

    public function getPaymentBreakdown(Request $request)
    {
        if ($request->ajax()) {
            $dateRange = $request->input('date_range');
            $paymentMethod = $request->input('payment_method');
            $status = $request->input('status');

            $query = Order::select(
                'payment_method',
                DB::raw('count(*) as count'),
                DB::raw('sum(total_amount) as total')
            );

            // Date filter
            if ($dateRange && is_numeric($dateRange)) {
                $startDate = Carbon::now()->subDays($dateRange);
                $query->where('created_at', '>=', $startDate);
            }

            // Payment method filter
            if ($paymentMethod) {
                $query->where('payment_method', $paymentMethod);
            }

            // Status filter
            if ($status) {
                $query->where('status', $status);
            }

            $breakdown = $query->groupBy('payment_method')->get();
            $totalOrders = $breakdown->sum('count');

            $formatted = $breakdown->map(function ($item) use ($totalOrders) {
                return [
                    'method' => ucfirst($item->payment_method),
                    'count' => $item->count,
                    'total' => round($item->total, 2),
                    'percentage' => $totalOrders > 0 ? round(($item->count / $totalOrders) * 100, 1) : 0
                ];
            });

            // All possible payment methods
            $allMethods = ['stripe', 'paydibs', 'wallet'];

            // Ensure all methods are included even if count = 0
            $result = collect($allMethods)->map(function ($method) use ($formatted, $totalOrders) {
                $existing = $formatted->firstWhere('method', ucfirst($method));
                return $existing ?: [
                    'method' => ucfirst($method),
                    'count' => 0,
                    'total' => 0.00,
                    'percentage' => 0
                ];
            });

            return response()->json($result);
        }
    }

    public function getNewCustomers(Request $request)
    {
        if ($request->ajax()) {
            $dateRange = $request->input('date_range');

            $query = User::where('role_id', 'customer');

            if ($dateRange && is_numeric($dateRange)) {
                $startDate = Carbon::now()->subDays($dateRange);
                $query->where('created_at', '>=', $startDate);
            }

            $newCustomers = $query->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(['id', 'name', 'last_name', 'avatar', 'email', 'created_at']);

            $result = $newCustomers->map(function ($customer) {
                $avatarPath = public_path($customer->avatar);
                $hasAvatar = !empty($customer->avatar) && file_exists($avatarPath);

                return [
                    'id' => $customer->id,
                    'name' => $customer->name . ' ' . $customer->last_name,
                    'email' => $customer->email,
                    'avatar' => $hasAvatar ? asset($customer->avatar) : null,
                    'initials' => $this->getInitials($customer->name),
                    'joined_date' => $customer->created_at->format('d/m/Y'),
                ];
            });

            return response()->json($result);
        }
    }

    public function getHeatmapData(Request $request)
    {
        if ($request->ajax()) {
            $period = $request->input('period', 'last_6_months');
            $paymentMethod = $request->input('payment_method');
            $status = $request->input('status');

            // Apply filters
            $orderQuery = Order::query();

            if ($paymentMethod) {
                $orderQuery->where('payment_method', $paymentMethod);
            }

            if ($status) {
                $orderQuery->where('status', $status);
            }

            $result = [
                'overall' => [],
                'last_12_months' => [],
                'last_6_months' => []
            ];

            // === OVERALL HEATMAP ===
            $overallData = (clone $orderQuery)->select(
                DB::raw('DAYOFWEEK(created_at) as day_of_week'),
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('COUNT(*) as order_count')
            )
                ->groupBy('day_of_week', 'hour')
                ->get();

            $matrix = $this->initializeHeatmapMatrix();
            $maxSales = $overallData->max('total_sales') ?: 1;

            foreach ($overallData as $data) {
                $intensity = ceil(($data->total_sales / $maxSales) * 5);
                $matrix[$data->day_of_week][$data->hour] = [
                    'sales' => round($data->total_sales, 2),
                    'orders' => $data->order_count,
                    'intensity' => $intensity
                ];
            }

            $result['overall'] = $this->formatHeatmapData($matrix);

            // === LAST 12 MONTHS HEATMAP ===
            $last12MonthsData = (clone $orderQuery)->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('COUNT(*) as order_count')
            )
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy('year', 'month')
                ->get();

            $monthsMatrix = $this->initializeMonthsMatrix(12);
            $maxMonthSales = $last12MonthsData->max('total_sales') ?: 1;

            foreach ($last12MonthsData as $data) {
                $monthKey = Carbon::create($data->year, $data->month)->format('Y-m');
                $intensity = ceil(($data->total_sales / $maxMonthSales) * 5);
                $monthsMatrix[$monthKey] = [
                    'sales' => round($data->total_sales, 2),
                    'orders' => $data->order_count,
                    'intensity' => $intensity,
                    'month' => Carbon::create($data->year, $data->month)->format('M Y')
                ];
            }

            $result['last_12_months'] = array_values($monthsMatrix);

            // === LAST 6 MONTHS HEATMAP ===
            $last6MonthsData = (clone $orderQuery)->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('COUNT(*) as order_count')
            )
                ->where('created_at', '>=', Carbon::now()->subMonths(6))
                ->groupBy('year', 'month')
                ->get();

            $monthsMatrix = $this->initializeMonthsMatrix(6);
            $maxMonthSales = $last6MonthsData->max('total_sales') ?: 1;

            foreach ($last6MonthsData as $data) {
                $monthKey = Carbon::create($data->year, $data->month)->format('Y-m');
                $intensity = ceil(($data->total_sales / $maxMonthSales) * 5);
                $monthsMatrix[$monthKey] = [
                    'sales' => round($data->total_sales, 2),
                    'orders' => $data->order_count,
                    'intensity' => $intensity,
                    'month' => Carbon::create($data->year, $data->month)->format('M Y')
                ];
            }

            $result['last_6_months'] = array_values($monthsMatrix);

            return response()->json($result[$period]);
        }
    }

    public function getOrdersData(Request $request)
    {
        if ($request->ajax()) {
            $dateRange = $request->input('date_range');
            $paymentMethod = $request->input('payment_method');
            $status = $request->input('status');
            $customerType = $request->input('customer_type');

            $query = Order::query()
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select(
                    'orders.id',
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
                ->with(['user', 'items.product']);

            // Apply date range filter only if provided
            if ($dateRange && is_numeric($dateRange)) {
                $startDate = Carbon::now()->subDays($dateRange);
                $query->where('orders.created_at', '>=', $startDate);
            }

            if ($paymentMethod) {
                $query->where('orders.payment_method', $paymentMethod);
            }

            if ($status) {
                $query->where('orders.status', $status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('order_id', function ($order) {
                    return $order->order_number;
                })
                ->addColumn('customer', function ($order) {
                    $canViewUser = auth()->user()->can(\App\Services\PermissionMap::getPermission('admin.customer.view'));

                    if (($order->user_name || $order->user_last_name) && $canViewUser && $order->user_id) {
                        return '<a href="' . route('admin.user.view', $order->user_id) . '">' . trim($order->user_name . ' ' . $order->user_last_name) . '</a>';
                    } elseif ($order->user_name || $order->user_last_name) {
                        return trim($order->user_name . ' ' . $order->user_last_name);
                    } elseif ($order->guest_name) {
                        return $order->guest_name;
                    }

                    return 'N/A';
                })
                ->addColumn('items', function ($order) {
                    $html = '<div class="d-flex flex-wrap gap-1">';
                    foreach ($order->items as $item) {
                        $html .= '<div class="badge bg-light text-dark border">' .
                            e($item->product->name . ' x' . $item->quantity) .
                            '</div>';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->addColumn('order_date', function ($order) {
                    return $order->created_at->format('d M, Y') . '<br><small>' . $order->created_at->format('h:i A') . '</small>';
                })
                ->addColumn('total_amount', function ($order) {
                    return number_format($order->total_amount, 2);
                })
                ->addColumn('payment_method', function ($order) {
                    $classes = [
                        'stripe' => 'payment-stripe',
                        'paydibs' => 'payment-paydibs',
                        'wallet' => 'payment-wallet'
                    ];
                    $class = isset($classes[strtolower($order->payment_method)]) ? $classes[strtolower($order->payment_method)] : '';
                    return '<span class="payment-method ' . $class . '">' . ucfirst($order->payment_method) . '</span>';
                })
                ->addColumn('status', function ($order) {
                    $statusClasses = [
                        'pending'    => 'badge bg-warning-subtle text-warning fw-medium',
                        'processing' => 'badge bg-info-subtle text-info fw-medium',
                        'completed'  => 'badge bg-success-subtle text-success fw-medium',
                        'failed'     => 'badge bg-danger-subtle text-danger fw-medium',
                        'cancelled'  => 'badge bg-secondary-subtle text-secondary fw-medium',
                    ];
                    $statusBadgeClass = $statusClasses[strtolower($order->status)] ?? 'badge bg-secondary-subtle text-secondary';
                    return '<span class="' . $statusBadgeClass . '">' . ucfirst($order->status) . '</span>';
                })
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
                    $query->whereRaw("LOWER(orders.status) LIKE ?", ["%{$keyword}%"]);
                })
                ->orderColumn('customer', function ($query, $order) {
                    $query->orderByRaw("COALESCE(users.name, users.last_name, order_details.name) {$order}");
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
                ->rawColumns(['order_id', 'customer', 'items', 'order_date', 'total_amount', 'payment_method', 'status'])
                ->make(true);
        }
    }

    // New method to fetch all orders data for PDF without pagination
    public function getOrdersDataForPDF(Request $request)
    {
        $dateRange = $request->input('date_range');
        $paymentMethod = $request->input('payment_method');
        $status = $request->input('status');
        $customerType = $request->input('customer_type');

        $query = Order::query()
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(
                'orders.id',
                'orders.order_number as invoice_number',
                'orders.created_at as date',
                'orders.status',
                'orders.total_amount as amount',
                'orders.payment_method',
                'orders.user_id',
                DB::raw("COALESCE(CONCAT(users.name, ' ', users.last_name), order_details.name, 'N/A') as customer_name")
            )
            ->with(['user', 'items.product']);

        // Apply filters (same as before)
        if ($dateRange && is_numeric($dateRange)) {
            $startDate = Carbon::now()->subDays($dateRange);
            $query->where('orders.created_at', '>=', $startDate);
        }
        if ($paymentMethod) {
            $query->where('orders.payment_method', $paymentMethod);
        }
        if ($status) {
            $query->where('orders.status', $status);
        }

        $orders = $query->orderBy('orders.created_at', 'desc')->get();

        return $orders->map(function ($order) {
            // Get items for this order
            $items = $order->items->map(function ($item) {
                return [
                    'name' => $item->product->name ?? 'Unknown Product',
                    'quantity' => $item->quantity
                ];
            })->toArray();

            return [
                'invoice_number' => $order->invoice_number,
                'date' => runtimeDateFormat($order->date),
                'customer_name' => $order->customer_name,
                'items' => $items, // Items array add kiya
                'amount' => $order->amount,
                'status' => ucfirst($order->status),
                'payment_method' => ucfirst($order->payment_method),
            ];
        });
    }
    public function generatePDF(Request $request)
    {
        // Fetch all orders data for PDF
        $sales = $this->getOrdersDataForPDF($request);

        // Load the Blade view with sales data
        $pdf = Pdf::loadView('admin.sales.pdf', [
            'sales' => $sales
        ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial',
                'fontCache' => storage_path('fonts/'),
                'isPhpEnabled' => true,
                'dpi' => 150,
                'defaultPaperSize' => 'a4',
                'enable_table_header_repeat' => true,
                'table_header_repeat' => true,
                'debugKeepTemp' => false,
                'debugCss' => false,
                'debugLayout' => false,
                'debugLayoutLines' => false,
                'debugLayoutBlocks' => false,
                'debugLayoutInline' => false,
                'debugLayoutPaddingBox' => false,
            ]);

        return $pdf->download('Sales_Report.pdf');
    }

    private function getInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return substr($initials, 0, 2);
    }

    private function initializeHeatmapMatrix()
    {
        $matrix = [];
        for ($day = 1; $day <= 7; $day++) {
            for ($hour = 0; $hour < 24; $hour++) {
                $matrix[$day][$hour] = [
                    'sales' => round(0, 2),
                    'orders' => 0,
                    'intensity' => 0
                ];
            }
        }
        return $matrix;
    }

    private function initializeMonthsMatrix($months)
    {
        $matrix = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $monthKey = Carbon::now()->subMonths($i)->format('Y-m');
            $matrix[$monthKey] = [
                'sales' => round(0, 2),
                'orders' => 0,
                'intensity' => 0,
                'month' => Carbon::now()->subMonths($i)->format('M Y')
            ];
        }
        return $matrix;
    }

    private function formatHeatmapData($matrix)
    {
        $timeSlots = [3, 6, 9, 12, 15]; // 3am, 6am, 9am, 12pm, 3pm
        $result = [];

        foreach ($timeSlots as $slot) {
            $dayData = [];
            for ($day = 2; $day <= 7; $day++) { // Monday to Saturday
                $dayData[] = $matrix[$day][$slot];
            }
            $dayData[] = $matrix[1][$slot]; // Sunday
            $result[] = $dayData;
        }

        return $result;
    }
}
