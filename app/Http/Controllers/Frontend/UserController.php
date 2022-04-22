<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
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
        OrderItem::where('order_id',$id)->delete();

        $orders = Order::where('user_id', Auth::id())->get();
        return view('frontend.order.index', compact('orders'))->with('status', 'Pesanan telah dibatalkan!');
    }
}
