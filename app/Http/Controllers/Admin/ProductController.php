<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Blade;

class ProductController extends Controller
{
    public function list()
    {
        return view('admin.products.list');
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with(['category', 'variants'])
                ->withCount('variants')
                ->select('products.*');
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
                    return Blade::render('
                        <div style="display: flex; gap: 8px;">
                            @hasRoutePermission("admin.product.edit")
                                <a href="{{ route("admin.product.edit", $product->id) }}" class="action_btn edit-item">
                                    <i class="ri-edit-line"></i>
                                </a>
                            @endhasRoutePermission
                            @hasRoutePermission("admin.product.destroy")
                                <form method="POST" action="{{ route("admin.product.destroy", $product->id) }}" style="display:inline;">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="action_btn delete-item show_confirm" data-name="Product">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            @endhasRoutePermission
                            @if (!auth()->user()->hasPermissionTo(\App\Services\PermissionMap::getPermission("admin.product.edit")) && 
                                !auth()->user()->hasPermissionTo(\App\Services\PermissionMap::getPermission("admin.product.destroy")))
                                <span>-</span>
                            @endif
                        </div>
                    ', ['product' => $product]);
                })
                ->addColumn('published_date', function ($product) {
                    return runTimeDateFormat($product->created_at);
                })

                ->filterColumn('category', function ($query, $keyword) {
                    $query->whereHas('category', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($keyword) . "%"]);
                    });
                })

                ->filterColumn('variants', function ($query, $keyword) {
                    $query->whereHas('variants', function ($q) use ($keyword) {
                        $q->select('product_id') // <- safer
                            ->groupBy('product_id')
                            ->havingRaw('COUNT(*) LIKE ?', ["%$keyword%"]);
                    });
                })

                ->filterColumn('price_range', function ($query, $keyword) {
                    $query->whereHas('variants', function ($q) use ($keyword) {
                        $q->whereRaw('price LIKE ?', ["%$keyword%"]);
                    });
                })

                ->filterColumn('status', function ($query, $keyword) {
                    $query->whereRaw('LOWER(status) LIKE ?', ["%" . strtolower($keyword) . "%"]);
                })

                ->filterColumn('name', function ($query, $keyword) {
                    $query->whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($keyword) . "%"]);
                })
                ->filterColumn('published_date', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->whereDate('products.created_at', $keyword)
                            ->orWhereRaw("DATE_FORMAT(products.created_at, '%Y-%m-%d') LIKE ?", ["%{$keyword}%"])
                            ->orWhereRaw("DATE_FORMAT(products.created_at, '%d-%m-%Y') LIKE ?", ["%{$keyword}%"])
                            ->orWhereRaw("DATE_FORMAT(products.created_at, '%M') LIKE ?", ["%{$keyword}%"]);
                    });
                })

                ->orderColumn('category', function ($query, $order) {
                    $query->join('categories', 'products.category_id', '=', 'categories.id')
                        ->orderBy('categories.name', $order);
                })

                ->orderColumn('variants', function ($query, $order) {
                    $query->withCount('variants')->orderBy('variants_count', $order);
                })


                ->orderColumn('price_range', function ($query, $order) {
                    $query->leftJoin('product_variants as pv', 'products.id', '=', 'pv.product_id')
                        ->select('products.*', DB::raw('MIN(pv.price) as min_price'))
                        ->groupBy('products.id')
                        ->orderBy('min_price', $order);
                })

                ->orderColumn('name', function ($query, $order) {
                    $query->select('products.*')->orderBy('products.name', $order);
                })

                ->orderColumn('status', function ($query, $order) {
                    $query->select('products.*')->orderBy('products.status', $order);
                })
                ->orderColumn('published_date', function ($query, $order) {
                    $query->orderBy('products.created_at', $order);
                })


                ->rawColumns(['image', 'published_date', 'action'])
                ->make(true);
        }
    }


    public function add()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {

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
        $product->type = $request->type;
        $product->status = $request->status;
        $product->is_featured = $request->has('is_featured') ? 1 : 0;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->game_user_id = $request->has('game_user_id') ? 1 : 0;
        $product->game_server_id = $request->has('game_server_id') ? 1 : 0;
        $product->game_user_name = $request->has('game_user_name') ? 1 : 0;
        $product->game_email = $request->has('game_email') ? 1 : 0;
        $product->no_info_required = $request->has('no_info_required') ? 1 : 0;

        if ($request->featured_image) {
            $featuredImage = $request->file('featured_image');
            $featuredImageName = $request->slug . '_' . time() . '.' . $featuredImage->getClientOriginalExtension();
            $featuredImagePath = public_path('product/featured_image/');
            $featuredImage->move($featuredImagePath, $featuredImageName);

            if (file_exists(public_path($name =  $featuredImage->getClientOriginalName()))) {
                unlink(public_path($name));
            }

            $product->featured_image = 'product/featured_image/' . $featuredImageName;
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

    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::find($id);
        return view('admin.products.edit', compact('categories', 'product'));
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
        $product->type = $request->type;
        $product->status = $request->status;
        $product->is_featured = $request->has('is_featured') ? 1 : 0;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->game_user_id = $request->has('game_user_id') ? 1 : 0;
        $product->game_server_id = $request->has('game_server_id') ? 1 : 0;
        $product->game_user_name = $request->has('game_user_name') ? 1 : 0;
        $product->game_email = $request->has('game_email') ? 1 : 0;
        $product->no_info_required = $request->has('no_info_required') ? 1 : 0;
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

        return redirect()->route('admin.products.list')->with('success', 'Request has been completed');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->featured_image && file_exists(public_path($product->featured_image))) {
            unlink(public_path($product->featured_image));
        }

        ProductVariant::where('product_id', $product->id)->delete();

        $product->delete();

        return redirect()->back()->with('success', 'Request has been completed');
    }
}
