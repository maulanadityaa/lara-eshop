<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', '0')->get();

        return view('admin.order.index', compact('orders'));
    }

    public function view($id)
    {
        $orders = Order::where('id', $id)->first();
        if($orders){
            $cityId = $orders->city;
            $city = City::where('city_id', '=', $cityId)->first();
            $provinceId = $orders->province;
            $province = Province::where('province_id', '=', $provinceId)->first();
        }
        // dd($orders->orderitems);
        // dd($orders);

        // $old_cartitems = Cart::where('user_id', Auth::id())->get();
        // foreach ($old_cartitems as $item) {
        //     if (!Product::where('id', $item->prod_id)->where('stock', '>=', $item->prod_qty)->exists()) {
        //         $removeItem = Cart::where('user_id', Auth::id())->where('prod_id', $item->prod_id)->first();
        //         $removeItem->delete();
        //     }
        // }
        $cartitems = Cart::where('user_id', Auth::id())->get();
        // dd($cartitems);

        return view('admin.order.view', compact('orders', 'province', 'city', 'cartitems'));
    }

    public function confirmOrder($id)
    {
        $orders = Order::find($id);
        $orders->status = 1;
        $orders->update();

        return redirect('dashboard')->with('status', 'Pesanan Dikonfirmasi!');
    }

    public function declineOrder($id)
    {
        $orders = Order::find($id);
        $orders->status = 5;
        $orders->update();

        return redirect('dashboard')->with('cancel', 'Pesanan Ditolak!');
    }

    public function updateOrder(Request $request, $id)
    {
        $orders = Order::find($id);
        $orders->status = $request->order_status;
        $orders->noresi = $request->no_resi;
        $orders->update();

        return redirect('admin/orders')->with('status', 'Pesanan Sukses Diupdate!');
    }

    public function orderHistory()
    {
        $orders = Order::where('status','!=', '0')->get();
        // dd($orders);

        return view('admin.order.history', compact('orders'));
    }
}
