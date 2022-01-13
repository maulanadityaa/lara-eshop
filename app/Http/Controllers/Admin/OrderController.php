<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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

        return view('admin.order.view', compact('orders'));
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

        return view('admin.order.history', compact('orders'));
    }
}
