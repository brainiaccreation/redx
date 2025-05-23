<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftCardCode;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GiftCardCodeController extends Controller
{
    public function list()
    {
        return view('admin.codes.list');
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $codes = GiftCardCode::with(['product']);

            return DataTables::of($codes)
                ->addIndexColumn()
                ->addColumn('product', function ($code) {
                    return $code->product->name . ' - ' . $code->product_variant->name;
                })
                ->addColumn('status', function ($code) {
                    $statusClasses = [
                        'assigned'  => 'badge bg-secondary-subtle text-secondary fw-medium',
                        'unused'  => 'badge bg-success-subtle text-success fw-medium',
                        'used'     => 'badge bg-danger-subtle text-danger fw-medium',
                    ];
                    $badgeClass = $statusClasses[$code->status] ?? 'badge bg-primary-subtle text-primary';
                    return '<h5><span class="' . $badgeClass . '">' . ucfirst($code->status) . '</span></h5>';
                })
                ->addColumn('used_date', function ($code) {
                    return $code->used_date ? runTimeDateFormat($code->used_date) : '-';
                })

                ->addColumn('action', function ($code) {
                    if ($code->status == 'used') {
                        $editIcon = '<div style="display: flex;justify-content:center; gap: 8px;">--
                            </div>';
                    } else {
                        $editIcon = '
                            <div style="display: flex;justify-content:center; gap: 8px;">
                                <a href="' . route('admin.code.edit', $code->id) . '" class="action_btn edit-item">
                                    <i class="ri-edit-line"></i>
                                </a>
                            </div>
                        ';
                    }
                    return $editIcon;
                })

                ->rawColumns(['product', 'status', 'used_date', 'action'])
                ->make(true);
        }
    }

    public function add()
    {
        $products = Product::where('type', 'gift_card')->orderBy('id', 'DESC')->get();
        return view('admin.codes.create', compact('products'));
    }

    public function edit($id)
    {
        $code = GiftCardCode::find($id);
        $products = Product::where('type', 'gift_card')->orderBy('id', 'DESC')->get();
        return view('admin.codes.edit', compact('products', 'code'));
    }

    public function getProductVariants($id)
    {
        $variants = ProductVariant::where('product_id', $id)->get(['id', 'name']);
        return response()->json($variants);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:200',
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
        ]);
        $code = new GiftCardCode();
        $code->code = $request->code;
        $code->product_id = $request->product_id;
        $code->variant_id = $request->variant_id;
        $code->status = 'unused';
        $code->save();
        return redirect()->route('admin.code.list')->with('Request has been completed');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:200',
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
        ]);

        $code = GiftCardCode::find($id);
        $code->code = $request->code;
        $code->product_id = $request->product_id;
        $code->variant_id = $request->variant_id;
        $code->update();

        return redirect()->route('admin.code.list')->with('Request has been completed');
    }
}
