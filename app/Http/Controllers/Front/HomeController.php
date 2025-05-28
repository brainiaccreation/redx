<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\ProductVariant;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->take(12)->get();
        $featured_products = Product::where('is_featured', 1)->take(12)->get();
        $homeSliders = HomeSlider::orderBy('created_at', 'DESC')->get();
        return view('front.home', compact('products', 'featured_products', 'homeSliders'));
    }
    public function about()
    {
        return view('front.about');
    }
    public function shop(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $products = $query->paginate(12);
        $categories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();
        $minPrice = ProductVariant::min('price');
        $maxPrice = ProductVariant::max('price');
        return view('front.shop', compact('products', 'categories', 'minPrice', 'maxPrice'));
    }
    public function category($unique_id, $slug)
    {
        $current_category = Category::where('slug', $slug)->where('unique_id', $unique_id)->first();
        if (!$current_category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        $query = Product::query();

        $query->where('category_id', $current_category->id);

        $products = $query->paginate(12);
        $categories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();
        $minPrice = ProductVariant::min('price');
        $maxPrice = ProductVariant::max('price');
        return view('front.category', compact('products', 'categories', 'minPrice', 'maxPrice', 'current_category'));
    }

    public function contact()
    {
        return view('front.contact');
    }
    public function cart()
    {
        return view('front.cart');
    }
}
