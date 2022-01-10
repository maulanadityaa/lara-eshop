<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\City;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CheckoutController extends Controller
{
    public function index()
    {
        $old_cartitems = Cart::where('user_id', Auth::id())->get();
        foreach ($old_cartitems as $item) {
            if(!Product::where('id', $item->prod_id)->where('stock', '>=', $item->prod_qty)->exists()){
                $removeItem = Cart::where('user_id', Auth::id())->where('prod_id', $item->prod_id)->first();
                $removeItem->delete();
            }
        }
        $cartitems = Cart::where('user_id', Auth::id())->get();

        $provinces = Province::pluck('name', 'province_id');

        return view('frontend.checkout', compact('cartitems', 'provinces'));
    }

    public function getCities($id)
    {
        $city = City::where('province_id', $id)->pluck('name', 'city_id');
        return response()->json($city);
    }

    public function cekOngkir(Request $request)
    {
        $courier = $request->courier;
        $weight = $request->weight;
        $destination = $request->city_destination;
        $postal_code = $request->input('kode-pos');

        $cost = RajaOngkir::ongkosKirim([
            'origin'    => 134,
            'originType' => "city",
            'destination'    => $destination,
            'destinationType' => "subdistrict",
            'weight'    => $weight,
            'courier'    => $courier,
        ])->get();

        // dd($courier, $weight, $destination, $postal_code);
        return response()->json($cost);
    }
}
