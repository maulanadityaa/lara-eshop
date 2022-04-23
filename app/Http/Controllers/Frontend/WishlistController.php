<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->get();

        return view('frontend.wishlist', compact('wishlist'));
    }

    public function add(Request $request)
    {
        if(Auth::check()){
            $prod_id = $request->input('product_id');
            if(Product::find($prod_id)){
                $wishlist = new Wishlist();
                $wishlist->prod_id = $prod_id;
                $wishlist->user_id = Auth::id();
                $wishlist->save();

                return response()->json(['status' => 'Produk Berhasil Masuk Wishlist']);
            } else {
                return response()->json(['status' => 'Produk Tidak Tersedia']);
            }
        } else{
            return response()->json(['status' => 'Anda Harus Login Terlebih Dahulu']);
        }
    }

    public function deleteItem(Request $request)
    {
        if(Auth::check()){
            $prod_id = $request->input('prod_id');
            if(Wishlist::where('prod_id', $prod_id)->where('user_id', Auth::id())->exists()){
                $wishlist = Wishlist::where('prod_id', $prod_id)->where('user_id', Auth::id())->first();
                $wishlist->delete();

                return response()->json(['status' => 'Produk telah dihapus dari Wishlist']);
            }
        } else {
            return response()->json(['status' => 'Silahkan Login terlebih dahulu']);
        }
    }
}
