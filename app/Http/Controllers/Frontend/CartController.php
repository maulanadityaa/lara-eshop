<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ValidationRequest;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        $request->validate([
            'product_size' => 'required'
        ]);
        $product_id = $request->input('product_id');
        $product_qty = $request->input('product_qty');
        $product_size = $request->input('product_size');
        $note = $request->input('note');

        if (Auth::user()) {
            $prod_check = Product::where('id', $product_id)->first();

            if ($prod_check) {
                if (Cart::where('prod_id', $product_id)->where('user_id', Auth::id())->exists()) {
                    return response()->json(['status' => $prod_check->name . ' sudah ada di Keranjang']);
                } else {
                    $cartItem = new Cart();
                    $cartItem->prod_id = $product_id;
                    $cartItem->user_id = Auth::id();
                    $cartItem->prod_qty = $product_qty;
                    $cartItem->prod_size = $product_size;
                    $cartItem->message = $note;
                    $cartItem->save();

                    return response()->json(['status' => $prod_check->name . ' berhasil masuk keranjang']);
                }
            }
        } else {
            return response()->json(['status' => 'Silahkan Login terlebih dahulu']);
        }
    }

    public function viewCart()
    {
        $cartitems = Cart::where('user_id', Auth::id())->get();

        return view('frontend.cart', compact('cartitems'));
    }

    public function deleteProduct(Request $request)
    {
        if (Auth::check()) {
            $prod_id = $request->input('prod_id');
            if (Cart::where('prod_id', $prod_id)->where('user_id', Auth::id())->exists()) {
                $cartItem = Cart::where('prod_id', $prod_id)->where('user_id', Auth::id())->first();
                $cartItem->delete();

                return response()->json(['status' => 'Produk telah dihapus']);
            }
        } else {
            return response()->json(['status' => 'Silahkan Login terlebih dahulu']);
        }
    }

    public function updateCart(Request $request)
    {
        $product_id = $request->input('prod_id');
        $product_qty = $request->input('prod_qty');

        if (Auth::check()) {
            if (Cart::where('prod_id', $product_id)->where('user_id', Auth::id())->exists()) {
                $cart = Cart::where('prod_id', $product_id)->where('user_id', Auth::id())->first();
                $cart->prod_qty = $product_qty;
                $cart->update();
            }
        }
    }

    public function changeNote(Request $request)
    {
        $note = $request->input('note');
        $product_id = $request->input('prod_id');

        if (Auth::check()) {
            if (Cart::where('prod_id', $product_id)->where('user_id', Auth::id())->exists()) {
                $cart = Cart::where('prod_id', $product_id)->where('user_id', Auth::id())->first();
                $cart->message = $note;
                $cart->update();

                return response()->json(['status' => 'Catatan telah diganti']);
            }
        }
    }
}
