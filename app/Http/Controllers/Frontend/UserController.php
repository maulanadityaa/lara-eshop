<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        if ($request->has('status')) {
            if ($status != '') {
                $orders = Order::where('user_id', Auth::id())->where('status', $status)->orderBy('created_at', 'desc')->get();

                return view('frontend.order.index', compact('orders'));
            } else {
                $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

                return view('frontend.order.index', compact('orders'));
            }
        } else {
            $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

            return view('frontend.order.index', compact('orders'));
        }
    }

    public function view($id)
    {
        $orders = Order::where('id', $id)->where('user_id', Auth::id())->first();

        return view('frontend.order.view', compact('orders'));
    }

    public function cancelOrder($id)
    {
        DB::table('orders')->delete($id);
        // OrderItem::where('order_id', $id)->delete();

        $orderitems = OrderItem::where('order_id', $id)->get();
        // dd($orderitems);
        foreach ($orderitems as $item) {
            $product = Product::where('id', $item->prod_id)->first();
            // dd($item->qty);
            $product->stock = $product->stock + $item->qty;
            $product->update();
        }
        $orderitems->each->delete();

        $orders = Order::where('user_id', Auth::id())->get();
        return view('frontend.order.index', compact('orders'))->with('status', 'Pesanan telah dibatalkan!');
    }

    public function viewProfile()
    {
        $users = User::where('id', Auth::id())->first();
        if ($users) {
            $cityId = $users->kota;
            $city = City::where('city_id', '=', $cityId)->first();
            $provinceId = $users->provinsi;
            $province = Province::where('province_id', '=', $provinceId)->first();

            // dd($city->name);
            return view('frontend.user.index', compact('users', 'province', 'city',));
        }
    }

    public function editProfile()
    {
        $users = User::where('id', Auth::id())->first();
        if ($users) {
            $provinces = Province::pluck('name', 'province_id');

            return view('frontend.user.edit', compact('users', 'provinces'));
        }
    }

    public function updateProfile(Request $request)
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
            ],
            [
                'nohp.min' => 'No HP minimal 10 digit!',
                'required' => 'Data Harus Diisi dengan Lengkap!',
                'city_destination.gt' => 'Pilih Kota Dahulu!',
                'province_destination.gt' => 'Pilih Provinsi Dahulu!',
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

        $user = User::where('id', Auth::id())->first();
        $user->name = $request->fname;
        $user->lname = $request->lname;
        $user->nohp = $hp;
        $user->alamat = $request->address;
        $user->kota = $request->city_destination;
        $user->provinsi = $request->province_destination;
        $user->kodepos = $request->postal_code;
        $user->update();

        return $this->viewProfile()->with('status', 'Profil sukses diubah');
    }

    public function printPDF($id)
    {
        $orders = Order::where('id', $id)->where('user_id', Auth::id())->first();
        if ($orders) {
            $cityId = $orders->city;
            $city = City::where('city_id', '=', $cityId)->first();
            $provinceId = $orders->province;
            $province = Province::where('province_id', '=', $provinceId)->first();
        }

        $path = base_path('public/assets/logo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . ';base64,' . base64_encode($data);

        $pdf = PDF::loadView('frontend.order.invoice', ['orders' => $orders, 'city' => $city, 'province' => $province, 'logo' => $logo])->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download($orders->id . '.pdf');
    }
}
