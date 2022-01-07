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

    public function viewcategory($slug)
    {
        if(Category::where('slug', $slug)->exists()){
            $category = Category::where('slug', $slug)->first();
            $products = Product::where('cate_id', $category->id)->where('status', '0')->get();
            return view('frontend.product.index', compact('category', 'products'));
        }else{
            return redirect('/')->with('status', "Kategori Tidak Tersedia");
        }
    }
}
