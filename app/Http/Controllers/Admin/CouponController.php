<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            return $this->getCouponsDataTable();
        }

        // Get statistics for dashboard
        $stats = [
            'total_coupons' => Coupon::count(),
            'active_coupons' => Coupon::active()->notExpired()->count(),
            'total_usage' => Coupon::sum('used_count'),
            'expired_coupons' => Coupon::where('expiry_date', '<', Carbon::now()->toDateString())->count(),
        ];

        return view('admin.coupons.list', compact('stats'));
    }

    /**
     * Get DataTables data
     */
    private function getCouponsDataTable()
    {
        $coupons = Coupon::select([
            'id',
            'code',
            'type',
            'value',
            'min_amount',
            'max_discount',
            'usage_limit',
            'used_count',
            'expiry_date',
            'status',
            'description',
            'created_at'
        ]);

        return DataTables::of($coupons)
            ->addColumn('coupon_info', function ($coupon) {
                return view('admin.coupons.partials.coupon-info', compact('coupon'))->render();
            })
            ->addColumn('discount_info', function ($coupon) {
                return view('admin.coupons.partials.discount-info', compact('coupon'))->render();
            })
            ->addColumn('usage_info', function ($coupon) {
                return view('admin.coupons.partials.usage-info', compact('coupon'))->render();
            })
            ->addColumn('status_badge', function ($coupon) {
                if ($coupon->is_expired) {
                    return '<h5><span class="badge bg-danger-subtle text-danger fw-medium">Expired</span></h5>';
                }

                switch ($coupon->status) {
                    case 'active':
                        return '<h5><span class="badge bg-success-subtle text-success fw-medium">Active</span></h5>';
                    case 'inactive':
                        return '<h5><span class="badge bg-warning-subtle text-warning fw-medium">Inactive</span></h5>';
                    default:
                        return '<h5><span class="badge bg-secondary-subtle text-secondary fw-medium">Unknown</span></h5>';
                }
            })
            ->addColumn('actions', function ($coupon) {
                return view('admin.coupons.partials.actions', compact('coupon'))->render();
            })
            ->editColumn('expiry_date', function ($coupon) {
                $expiry = $coupon->expiry_date->format('M d, Y');
                if ($coupon->is_expired) {
                    $expiry .= '<br><small class="text-danger">Expired</small>';
                }
                return $expiry;
            })
            ->filterColumn('code', function ($query, $keyword) {
                $query->where('code', 'like', "%{$keyword}%");
            })
            ->filterColumn('status', function ($query, $keyword) {
                if ($keyword === 'expired') {
                    $query->where('expiry_date', '<', Carbon::now()->toDateString());
                } else {
                    $query->where('status', $keyword);
                }
            })
            ->rawColumns(['coupon_info', 'discount_info', 'usage_info', 'status_badge', 'actions', 'expiry_date'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0.01',
            'min_amount' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'expiry_date' => 'required|date|after:today',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Additional validation for percentage
        if ($request->type === 'percentage' && $request->value > 100) {
            return response()->json([
                'success' => false,
                'errors' => ['value' => ['Percentage value cannot be greater than 100']]
            ], 422);
        }

        $coupon = Coupon::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Coupon created successfully!',
            'coupon' => $coupon
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return response()->json([
            'success' => true,
            'coupon' => $coupon
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0.01',
            'min_amount' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'expiry_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:active,inactive,expired',
            'description' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Additional validation for percentage
        if ($request->type === 'percentage' && $request->value > 100) {
            return response()->json([
                'success' => false,
                'errors' => ['value' => ['Percentage value cannot be greater than 100']]
            ], 422);
        }

        // Don't allow reducing usage limit below current used count
        if ($request->usage_limit < $coupon->used_count) {
            return response()->json([
                'success' => false,
                'errors' => ['usage_limit' => ['Usage limit cannot be less than current used count (' . $coupon->used_count . ')']]
            ], 422);
        }

        $coupon->update($request->only([
            'code',
            'type',
            'value',
            'min_amount',
            'max_discount',
            'usage_limit',
            'expiry_date',
            'status',
            'description'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Coupon updated successfully!',
            'coupon' => $coupon->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);

        // Don't delete if coupon has been used
        if ($coupon->used_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete coupon that has been used. You can deactivate it instead.'
            ], 400);
        }

        $coupon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Coupon deleted successfully!'
        ]);
    }

    /**
     * Toggle coupon status
     */
    public function toggleStatus(Coupon $coupon)
    {
        $coupon->status = $coupon->status === 'active' ? 'inactive' : 'active';
        $coupon->save();

        return response()->json([
            'success' => true,
            'message' => 'Coupon status updated successfully!',
            'status' => $coupon->status
        ]);
    }

    /**
     * Apply coupon (for API or frontend use)
     */
    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'amount' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $coupon = Coupon::where('code', strtoupper($request->code))->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code'
            ], 404);
        }

        if (!$coupon->canBeUsed()) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon is not valid or has expired'
            ], 400);
        }

        if ($request->amount < $coupon->min_amount) {
            return response()->json([
                'success' => false,
                'message' => "Minimum order amount should be $" . number_format($coupon->min_amount, 2)
            ], 400);
        }

        $discount = $coupon->calculateDiscount($request->amount);

        return response()->json([
            'success' => true,
            'coupon' => $coupon,
            'discount' => $discount,
            'final_amount' => $request->amount - $discount
        ]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete,activate,deactivate',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:coupons,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $coupons = Coupon::whereIn('id', $request->ids);
        $count = $coupons->count();

        switch ($request->action) {
            case 'delete':
                // Only delete unused coupons
                $coupons->where('used_count', 0)->delete();
                break;
            case 'activate':
                $coupons->update(['status' => 'active']);
                break;
            case 'deactivate':
                $coupons->update(['status' => 'inactive']);
                break;
        }

        return response()->json([
            'success' => true,
            'message' => "Bulk action performed on {$count} coupons successfully!"
        ]);
    }
}
