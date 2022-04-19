<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', '0')->latest()->paginate(5);
        $orders_unconfirmed = Order::where('status', '0')->count();
        $orders_confirmed = Order::where('status', '!=', '0')->count();
        $orders_canceled = Order::where('status', '=', '5')->count();

        return view('admin.index', compact('orders_unconfirmed', 'orders_confirmed', 'orders', 'orders_canceled'));
    }
}
