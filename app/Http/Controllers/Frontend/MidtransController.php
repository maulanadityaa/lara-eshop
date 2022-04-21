<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function submitPayment(Request $request)
    {
        $callback = json_decode($request->get('midtrans_callback'));
        // dd($callback);
        // return $request;
        $orders = Order::findOrFail($callback->order_id);

        if ($orders) {
            if(strtolower($callback->transaction_status) == 'pending'){
                $orders->status = 1;
            } elseif (strtolower($callback->transaction_status) == 'settlement' || 'capture'){
                $orders->status = 2;
            } elseif (strtolower($callback->transaction_status) == 'deny' || 'cancel' || 'expire'){
                $orders->status = 5;
            }   
            $orders->midtrans_status = $callback->transaction_status;
            $orders->payment_type = $callback->payment_type;
            $orders->payment_code = isset($callback->payment_code) ? $callback->payment_code : null;
            $orders->pdf_url = isset($callback->pdf_url) ? $callback->pdf_url : null;
            $orders->update();

            return redirect('/my-orders')->with('status', 'Pembayaranmu Sedang Diproses!');
        }

        return view('frontend.order.index')->with('error', 'Order tidak ditemukan!');
    }
}
