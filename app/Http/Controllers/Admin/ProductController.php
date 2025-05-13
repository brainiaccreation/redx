<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
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
                    return $product->featured_image
                            ? '<img src="' . asset($product->featured_image) . '" width="50" class="table-image" />'
                            : '<div class="user-name-avatar">' . usernameAvatar($product->name) . '</div>';

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
                    return '<a href="'.route('admin.product.edit', $product->id).'" class=" action_btn edit-item"><i class="ri-edit-line"></i></a>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
    }

    public function add() {
        $categories = Category::all();
        return view('admin.products.create',compact('categories'));
    }

    public function store(Request $request) {

         $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive,draft',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'featured_image' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->category_id = $request->category_id;
        $product->status = $request->status;
        $product->is_featured = $request->has('is_featured') ? 1 : 0;
        $product->short_description = $request->short_description;
        $product->description = $request->description;

        if ($request->featured_image) {
            $featuredImage = $request->file('featured_image');
            $featuredImageName = $request->slug.'_'.time() . '.' . $featuredImage->getClientOriginalExtension();
            $featuredImagePath = public_path('product/featured_image/');
            $featuredImage->move($featuredImagePath, $featuredImageName);

            if (file_exists(public_path($name =  $featuredImage->getClientOriginalName()))) 
            {
                unlink(public_path($name));
            };
            $product->featured_image = 'product/featured_image/'.$featuredImageName;
        }
        $product->save();

        $variantNames = $request->variant_name;
        $variantSkus = $request->variant_sku;
        $variantRegions = $request->variant_region;
        $variantDenominations = $request->variant_denomination;
        $variantPrices = $request->variant_price;
        $variantOrders = $request->variant_order;

        if (is_array($variantNames)) {
            foreach ($variantNames as $index => $name) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => $name,
                    'sku' => $variantSkus[$index] ?? null,
                    'region' => $variantRegions[$index] ?? null,
                    'denomination' => $variantDenominations[$index] ?? null,
                    'price' => $variantPrices[$index] ?? 0,
                    'order' => $variantOrders[$index] ?? $index,
                    'status' => 'active'
                ]);
            }
        }

        return redirect()->route('admin.products.list')->with('success', 'Request has been completed');
    }

    public function edit($id) {
        $categories = Category::all();
        $product = Product::find($id);
        return view('admin.products.edit',compact('categories','product'));
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:products,slug,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive,draft',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
        ]);

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->category_id = $request->category_id;
        $product->status = $request->status;
        $product->is_featured = $request->has('is_featured') ? 1 : 0;
        $product->short_description = $request->short_description;
        $product->description = $request->description;

        if ($request->hasFile('featured_image')) {
            if ($product->featured_image && file_exists(public_path($product->featured_image))) {
                unlink(public_path($product->featured_image));
            }

            $featuredImage = $request->file('featured_image');
            $featuredImageName = $request->slug . '_' . time() . '.' . $featuredImage->getClientOriginalExtension();
            $featuredImagePath = public_path('product/featured_image/');
            $featuredImage->move($featuredImagePath, $featuredImageName);

            $product->featured_image = 'product/featured_image/' . $featuredImageName;
        }

        $product->save();

        $variantIds = $request->variant_id;
        $variantNames = $request->variant_name;
        $variantSkus = $request->variant_sku;
        $variantRegions = $request->variant_region;
        $variantDenominations = $request->variant_denomination;
        $variantPrices = $request->variant_price;
        $variantOrders = $request->variant_order;

        $updatedVariantIds = [];
        return $request->variant_id;
        if (is_array($variantNames)) {
            foreach ($variantNames as $index => $name) {
                $variantId = $variantIds[$index] ?? null;

                $data = [
                    'product_id' => $product->id,
                    'name' => $name,
                    'sku' => $variantSkus[$index] ?? null,
                    'region' => $variantRegions[$index] ?? null,
                    'denomination' => $variantDenominations[$index] ?? null,
                    'price' => $variantPrices[$index] ?? 0,
                    'order' => $variantOrders[$index] ?? $index,
                    'status' => 'active',
                ];

                if ($variantId) {
                    $variant = ProductVariant::find($variantId);
                    if ($variant) {
                        $variant->update($data);
                        $updatedVariantIds[] = $variantId;
                    }
                } else {
                    $variant = ProductVariant::create($data);
                    $updatedVariantIds[] = $variant->id;
                }
            }

            ProductVariant::where('product_id', $product->id)
                ->whereNotIn('id', $updatedVariantIds)
                ->delete();
        }


        return redirect()->route('admin.products.list')->with('success', 'Product updated successfully');
    }

}
