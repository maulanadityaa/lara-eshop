<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Province;
use App\Models\User;
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
            'origin'    => 164,
            'destination'    => $destination,
            'weight'    => $weight,
            'courier'    => $courier,
        ])->get();

        // dd($courier, $weight, $destination, $postal_code);
        return response()->json($cost);
    }

    public function placeOrder(Request $request)
    {
        $order = new Order();
        $order->user_id = Auth::id();
        $order->fname = $request->fname;
        $order->lname = $request->lname;
        $order->email = $request->email;
        $order->nohp = $request->nohp;
        $order->address = $request->address;
        $order->city = $request->city_destination;
        $order->province = $request->province_destination;
        $order->postal_code = $request->postal_code;
        $order->courier = $request->jasa_pengiriman;
        $order->total_price = $request->total_harga;
        $order->save();

        // Order::create([
        //     'user_id' => Auth::id(),
        //     'fname' => $request->input('fname'),
        //     'lname' => $request->input('lname'),
        //     'email' => $request->input('email'),
        //     'nohp' => $request->input('nohp'),
        //     'address' => $request->input('address'),
        //     'city' => $request->input('city_destination'),
        //     'province' => $request->input('province_destination'),
        //     'postal_code' => $request->input('postal_code'),
        //     'courier' => $request->input('jasa_pengiriman'),
        //     'total_price' => $request->input('total_harga')
        // ]);

        $cartitems = Cart::where('user_id', Auth::id())->get();
        foreach ($cartitems as $item) {
            OrderItem::create([
                'order_id' => 1,
                'prod_id' => $item->prod_id,
                'qty' => $item->prod_qty,
                'price' => $item->products->sell_price
            ]);

            $product = Product::where('id', $item->prod_id)->first();
            $product->stock = $product->stock - $item->prod_qty;
            $product->update();
        }

        if(Auth::user()->alamat == NULL){
            $user = User::where('id', Auth::id())->first();
            $user->name = $request->fname;
            $user->lname = $request->lname;
            $user->nohp = $request->nohp;
            $user->alamat = $request->address;
            $user->kota = $request->city_destination;
            $user->provinsi = $request->province_destination;
            $user->kodepos = $request->postal_code;
            $user->update();
        }

        $cartitems = Cart::where('user_id', Auth::id())->get();
        Cart::destroy($cartitems);

        return redirect('/')->with('status', 'Pesanan telah dibuat!!');
    }
}
