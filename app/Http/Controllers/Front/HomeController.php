<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

class HomeController extends Controller
{
    public function index() {
        $products = Product::latest()->take(12)->get();
        $featured_products = Product::where('is_featured',1)->take(12)->get();
        return view('front.home',compact('products','featured_products'));
    }
    public function about() {
        return view('front.about');
    }
    public function shop(Request $request) {
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
        return view('front.shop',compact('products','categories','minPrice','maxPrice'));
    }
    public function contact() {
        return view('front.contact');
    }
    public function cart() {
        return view('front.cart');
    }
}
