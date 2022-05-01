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
            if (strtolower($callback->transaction_status) == 'pending') {
                $orders->status = 1;
            } elseif (strtolower($callback->transaction_status) == 'settlement' || 'capture') {
                $orders->status = 2;
            } elseif (strtolower($callback->transaction_status) == 'deny' || 'cancel' || 'expire') {
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

    public function updateStatus($id)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $orders = Order::findOrFail($id);
        /** @var object $status */
        $status = \Midtrans\Transaction::status($id);
        $newStatus = json_encode($status);
        // dd($status);
        if ($status && $orders) {
            if ($status->transaction_status != $orders->id) {
                if (strtolower($status->transaction_status) == $orders->midtrans_status) {
                    return redirect()->back()->with('error', 'Status Pesanan dengan ID ' . $id . ' belum ada perubahan');
                } elseif (strtolower($status->transaction_status) == 'settlement') {
                    $orders->status = 2;
                } elseif (strtolower($status->transaction_status) == 'capture') {
                    $orders->status = 2;
                } elseif (strtolower($status->transaction_status) == 'deny') {
                    $orders->status = 5;
                } elseif (strtolower($status->transaction_status) == 'cancel') {
                    $orders->status = 5;
                } elseif (strtolower($status->transaction_status) == 'expire') {
                    $orders->status = 5;
                }
                $orders->midtrans_status = $status->transaction_status;
                $orders->update();
                return redirect()->back()->with('status', 'Status Pesanan dengan ID ' . $id . ' telah diperbarui');
            }
            return redirect()->back()->with('error', 'Status Pesanan dengan ID ' . $id . ' tidak ada');
        }
    }
}
