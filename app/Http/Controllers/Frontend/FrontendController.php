<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $featured_products = Product::where('trending', '1')->take(10)->get();
        $featured_categories = Category::where('popular', '1')->take(10)->get();
        // dd($featured_products);
        return view('frontend.index', compact('featured_products', 'featured_categories'));
    }

    public function category()
    {
        $category = Category::all();
        return view('frontend.category', compact('category'));
    }
}
