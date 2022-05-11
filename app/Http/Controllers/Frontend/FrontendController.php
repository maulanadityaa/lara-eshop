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
        $products = Product::where('stock', '!=', '0')->paginate(4);
        // dd($featured_products);
        return view('frontend.index', compact('featured_products', 'products'));
    }

    public function allProducts()
    {
        $products = Product::where('stock', '!=', '0')->latest()->paginate(8);
        // dd($featured_products);
        return view('frontend.all-products', compact('products'));
    }

    public function category()
    {
        $category = Category::all();
        return view('frontend.category', compact('category'));
    }

    public function viewcategory($slug)
    {
        // $cek_kate = Product::where('cate_id', $category->id)->where('status', '0')->get();
        // dd($cek_kate);
        if (Category::where('slug', $slug)->exists()) {
            $category = Category::where('slug', $slug)->first();
            $products = Product::where('cate_id', $category->id)->where('status', '0')->get();
            // dd($products);
            return view('frontend.product.index', compact('category', 'products'));
        } else {
            return redirect('/')->with('status', "Kategori Tidak Tersedia");
        }
    }

    public function viewproduct($cate_slug, $prod_slug)
    {
        // $kate = $cate_slug;
        // $cek_kate = Category::where('slug', $cate_slug)->exists();
        // dd($cek_kate);
        if (Category::where('slug', $cate_slug)->exists()) {
            if (Product::where('slug', $prod_slug)->exists()) {
                $product = Product::where('slug', $prod_slug)->first();
                return view('frontend.product.view', compact('product'));
            } else {
                return redirect('/')->with('status', 'Produk Tidak Tersedia');
            }
        } else {
            return redirect('/')->with('status', "Kategori Tidak Tersedia");
        }
    }

    public function getProductName()
    {
        $products = Product::select('name')->get();
        $prod_name = [];

        foreach ($products as $item) {
            $prod_name[] = $item['name'];
        }

        return $prod_name;
    }

    public function searchProduct(Request $request)
    {
        $keyword = $request->keyword;

        if ($keyword != '') {
            $product = Product::where('name', 'LIKE', "%$keyword%")->first();
            if ($product) {
                return redirect('/view-category/' . $product->category->slug . '/' . $product->slug);
            } else {
                return redirect()->back()->with('error', 'Produk yang Anda Cari Tidak Ada');
            }
        } else {
            return redirect()->back();
        }
    }
}
