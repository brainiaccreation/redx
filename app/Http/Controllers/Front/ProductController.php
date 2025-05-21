<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
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
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 10000);
        $search   = $request->input('search');

        $variantQuery = ProductVariant::query()
            ->whereBetween('price', [$minPrice, $maxPrice]);

        if ($search) {
            $variantQuery->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $productIds = $variantQuery->pluck('product_id')->unique();

        $products = Product::whereIn('id', $productIds)->limit(12)->get();
        $html = view('front.layouts.partials.filtered-products', compact('products'))->render();

        return response()->json(['html' => $html]);
    }
}
