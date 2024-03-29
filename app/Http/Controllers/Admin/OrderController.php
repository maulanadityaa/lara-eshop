<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', '0')->latest()->paginate(5);

        return view('admin.order.index', compact('orders'));
    }

    public function view($id)
    {
        $orders = Order::where('id', $id)->first();
        if ($orders) {
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
        // dd($cartitems);

        return view('admin.order.view', compact('orders', 'province', 'city'));
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

    public function orderHistory(Request $request)
    {
        $month = $request->input('month');
        $keyword = $request->input('keyword');

        if ($request->has('month') && $request->has('keyword')) {
            if ($month != '' && $keyword != '') {
                $orders = Order::whereMonth('created_at', $month)->where('id', '=', $keyword)->latest()->paginate(5)->get();

                return view('admin.order.history', compact('orders'));
            } elseif ($month == '' && $keyword != '') {
                $orders = Order::where('id', '=', $keyword)->latest()->paginate(5);

                return view('admin.order.history', compact('orders'));
            } elseif ($month != '' && $keyword == '') {
                $orders = Order::whereMonth('created_at', $month)->latest()->paginate(5);

                return view('admin.order.history', compact('orders'));
            } else {
                $orders = Order::where('status', '!=', '0')->latest()->paginate(5);

                return view('admin.order.history', compact('orders'));
            }
        } else {
            $orders = Order::where('status', '!=', '0')->latest()->paginate(5);

            return view('admin.order.history', compact('orders'));
        }
    }

    public function printReport(Request $request)
    {
        $month = $request->input('month_print');

        $orders = Order::whereMonth('created_at', $month)->where('status', '=', '4')->get();
        $orders_cancel = Order::whereMonth('created_at', $month)->where('status', '=', '5')->get();
        $orders_month = Order::whereMonth('created_at', $month)->first();
        // dd($orders);

        if ($orders->count() > 0) {
            $pdf = PDF::loadView('admin.order.report', ['orders' => $orders, 'month' => $orders_month, 'orders_cancel' => $orders_cancel])->setOptions(['defaultFont' => 'sans-serif']);

            return $pdf->download('Laporan Penjualan Bulan ' . date('F'), strtotime($orders_month->created_at) . '.pdf');
        } else {
            return redirect()->back()->with('cancel', 'Tidak Ada Penjualan yang Selesai di Bulan yang Dipilih');
        }
    }
}
