<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftCardCode;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Blade;

class GiftCardCodeController extends Controller
{
    public function list()
    {
        return view('admin.codes.list');
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $codes = GiftCardCode::with(['product', 'product_variant'])->select('gift_card_codes.*');


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
                    if ($code->used_date) {
                        $used_date = '<div style="display: flex;justify-content:center; gap: 8px;">--
                            </div>';
                    } else {
                        $used_date = runTimeDateFormat($code->used_date);
                    }
                    return $used_date;
                })

                ->addColumn('action', function ($code) {
                    $canEdit = auth()->user()->can(\App\Services\PermissionMap::getPermission('admin.code.edit'));

                    return '
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            ' . ($code->status != 'index' && $canEdit
                        ? '<a href="' . route('admin.code.edit', $code->id) . '" class="action_btn edit-item">
                                        <i class="ri-edit-line"></i>
                                </a>'
                        : '<span>-</span>') . '
                        </div>
                    ';
                })

                ->addColumn('published_date', function ($code) {
                    return runTimeDateFormat($code->created_at);
                })
                ->filterColumn('product', function ($query, $keyword) {
                    $query->whereHas('product', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                    })->orWhereHas('product_variant', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                    });
                })

                ->filterColumn('status', function ($query, $keyword) {
                    $query->whereRaw('LOWER(status) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->filterColumn('published_date', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->whereDate('gift_card_codes.created_at', $keyword)
                            ->orWhereRaw("DATE_FORMAT(gift_card_codes.created_at, '%Y-%m-%d') LIKE ?", ["%{$keyword}%"])
                            ->orWhereRaw("DATE_FORMAT(gift_card_codes.created_at, '%d-%m-%Y') LIKE ?", ["%{$keyword}%"])
                            ->orWhereRaw("DATE_FORMAT(gift_card_codes.created_at, '%M') LIKE ?", ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('used_date', function ($query, $keyword) {
                    $query->whereRaw('DATE_FORMAT(used_date, "%d-%m-%Y") LIKE ?', ["%$keyword%"]);
                })
                ->orderColumn('product', function ($query, $order) {
                    $query->join('products', 'gift_card_codes.product_id', '=', 'products.id')
                        ->join('product_variants', 'gift_card_codes.product_variant_id', '=', 'product_variants.id')
                        ->orderByRaw("CONCAT(products.name, ' - ', product_variants.name) $order")
                        ->select('gift_card_codes.*');
                })

                ->orderColumn('status', function ($query, $order) {
                    $query->select('gift_card_codes.*')->orderBy('status', $order);
                })

                ->orderColumn('used_date', function ($query, $order) {
                    $query->select('gift_card_codes.*')->orderBy('used_date', $order);
                })
                ->orderColumn('published_date', function ($query, $order) {
                    $query->orderBy('gift_card_codes.created_at', $order);
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
