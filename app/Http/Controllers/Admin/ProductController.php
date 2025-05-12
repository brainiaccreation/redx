<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
class ProductController extends Controller
{
    public function list() {
        return view('admin.products.list');
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with(['category', 'variants']);

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('image', function ($product) {
                    return '<img src="' . asset($product->featured_image) . '" width="50" />';
                })
                ->addColumn('category', function ($product) {
                    return $product->category ? $product->category->name : 'N/A';
                })
                ->addColumn('variants', function ($product) {
                    return $product->variants->count();
                })
                ->addColumn('price_range', function ($product) {
                    $prices = $product->variants->pluck('price');
                    if ($prices->isEmpty()) return 'N/A';
                    $min = number_format($prices->min(), 2);
                    $max = number_format($prices->max(), 2);
                    return $min === $max ? "$$min" : "$$min - $$max";
                })
                ->addColumn('status', function ($product) {
                    return ucfirst($product->status);
                })
                ->addColumn('action', function ($product) {
                    return '<a href="'.route('admin.product.edit', $product->id).'" class="btn btn-sm btn-primary">Edit</a>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
    }

    public function add() {
        $categories = Category::all();
        return view('admin.products.create',compact('categories'));
    }
}
