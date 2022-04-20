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
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class CheckoutController extends Controller
{
    public function index()
    {
        $old_cartitems = Cart::where('user_id', Auth::id())->get();
        foreach ($old_cartitems as $item) {
            if (!Product::where('id', $item->prod_id)->where('stock', '>=', $item->prod_qty)->exists()) {
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
        $request->validate(
            [
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'required',
                'address' => 'required',
                'nohp' => 'required|min:10',
                'city_destination' => 'required|gt:1',
                'province_destination' => 'required|gt:1',
                'postal_code' => 'required',
                'jasa_pengiriman' => 'required',
                'total_ongkir' => 'required|gt:1000'
            ],
            [
                'nohp.min' => 'No HP minimal 10 digit!',
                'required' => 'Data Harus Diisi dengan Lengkap!',
                'city_destination.gt' => 'Pilih Kota Tujuan Dahulu!',
                'province_destination.gt' => 'Pilih Provinsi Tujuan Dahulu!',
                'total_ongkir.gt' => 'Total Ongkos Kirim Harus Ada!',
            ]
        );

        if (!preg_match('/[^+0-9]/', trim($request->nohp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($request->nohp), 0, 3) == '+62') {
                $hp = trim($request->nohp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr(trim($request->nohp), 0, 1) == '0') {
                $hp = '+62' . substr(trim($request->nohp), 1);
            }
        }

        $invid = IdGenerator::generate(['table' => 'orders', 'field' => 'id', 'length' => 10, 'prefix' => 'INV' . date('ymd')]);
        $id = $invid . Auth::user()->id . rand(10, 100);
        // dd($id);
        $order = new Order();
        $order->id = $id;
        $order->user_id = Auth::id();
        $order->fname = $request->fname;
        $order->lname = $request->lname;
        $order->email = $request->email;
        $order->nohp = $hp;
        $order->address = $request->address;
        $order->city = $request->city_destination;
        $order->province = $request->province_destination;
        $order->postal_code = $request->postal_code;
        $order->courier = $request->jasa_pengiriman;
        $order->ongkir = $request->total_ongkir;
        $order->total_price = $request->total_harga + $request->total_ongkir;
        $order->save();

        // Order::create([
        //     'user_id' => Auth::id(),
        //     'invoice_id' => $id,
        //     'fname' => $request->fname,
        //     'lname' => $request->lname,
        //     'email' => $request->email,
        //     'nohp' => $hp,
        //     'address' => $request->address,
        //     'city' => $request->city_destination,
        //     'province' => $request->province_destination,
        //     'postal_code' => $request->postal_code,
        //     'courier' => $request->jasa_pengiriman,
        //     'ongkir' => $request->total_ongkir,
        //     'total_price' => $request->total_harga + $request->total_ongkir
        // ]);

        $cartitems = Cart::where('user_id', Auth::id())->get();
        // dd($cartitems);
        foreach ($cartitems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'prod_id' => $item->prod_id,
                'prod_size' => $item->prod_size,
                'qty' => $item->prod_qty,
                'price' => $item->products->sell_price
            ]);

            $product = Product::where('id', $item->prod_id)->first();
            $product->stock = $product->stock - $item->prod_qty;
            $product->update();
        }

        if (Auth::user()->alamat == NULL) {
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

    public function payNow($id)
    {
        $orders = Order::findOrFail($id);
        // dd($orders);

        $customerDetails = [
            'first_name' => $orders->fname,
            'last_name' => $orders->lname,
            'email' => $orders->email,
            'phone' => $orders->nohp,
            'address' => $orders->address,
            'city' => $orders->city,
            'postal_code' => $orders->postal_code
        ];

        $transactionDetails = [
            'order_id' => $orders->id,
            'gross_amount' => $orders->total_price
        ];

        // dd($this->harga);

        $payload = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails
        ];

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        // dd(\Midtrans\Config::$serverKey = config('services.midtrans.serverKey'));
        $snapToken = \Midtrans\Snap::getSnapToken($payload);
        // dd($snapToken);

        if ($snapToken) {
            $orders->snaptoken = $snapToken;
            $orders->update();
        }
        
        return response()->json($snapToken);
    }
}
