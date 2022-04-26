<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();

        return view('frontend.order.index', compact('orders'));
    }

    public function view($id)
    {
        $orders = Order::where('id', $id)->where('user_id', Auth::id())->first();

        return view('frontend.order.view', compact('orders'));
    }

    public function cancelOrder($id)
    {
        DB::table('orders')->delete($id);
        OrderItem::where('order_id', $id)->delete();

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
                'city_destination.gt' => 'Pilih Kota Tujuan Dahulu!',
                'province_destination.gt' => 'Pilih Provinsi Tujuan Dahulu!',
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
        $user->nohp = $request->nohp;
        $user->alamat = $request->address;
        $user->kota = $request->city_destination;
        $user->provinsi = $request->province_destination;
        $user->kodepos = $request->postal_code;
        $user->update();

        return $this->viewProfile()->with('status', 'Profil sukses diubah');
    }
}
