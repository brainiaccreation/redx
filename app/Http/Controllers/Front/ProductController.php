<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductController extends Controller
{
    public function show($slug)
    {

        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();
        return view('front.products.detail', compact('product', 'relatedProducts'));
    }

    public function autocomplete(Request $request)
    {
        $search = $request->get('term');

        $products = Product::where('name', 'like', '%' . $search . '%')
            ->limit(10)
            ->get(['name', 'slug', 'featured_image']);

        $results = [];

        foreach ($products as $product) {
            $results[] = [
                'name'  => $product->name,
                'slug'  => $product->slug,
                'image' => $product->featured_image
                    ? asset($product->featured_image)
                    : URL('front/assets/img/product/01.jpg'),
                'url'   => route('product.detail', $product->slug),
            ];
        }

        return response()->json($results);
    }

    public function ajaxFilter(Request $request)
    {
        $search    = $request->input('search');
        $minPrice  = (float) $request->input('minPrice') ?? $request->query('minPrice');
        $maxPrice  = (float) $request->input('maxPrice') ?? $request->query('maxPrice');
        $categorySlug = $request->input('category') ?? $request->query('category');

        $variantQuery = ProductVariant::query();

        if (!is_null($minPrice) && !is_null($maxPrice)) {
            $variantQuery->whereBetween('price', [$minPrice, $maxPrice]);
        }

        if ($search) {
            $variantQuery->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $productIds = $variantQuery->pluck('product_id')->unique();

        $productsQuery = Product::whereIn('id', $productIds);

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();

            if ($category) {
                $productsQuery->where('category_id', $category->id);
            } else {
                $productsQuery->whereRaw('0 = 1');
            }
        }

        $products = $productsQuery->paginate(12);

        $categories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();

        $minPrice = ProductVariant::min('price');
        $maxPrice = ProductVariant::max('price');

        $html = view('front.shop', compact('products', 'categories', 'minPrice', 'maxPrice'))->render();

        return $html;
    }
}
