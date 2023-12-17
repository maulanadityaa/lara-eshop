<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function submitPayment(Request $request)
    {
        $callback = json_decode($request->get('midtrans_callback'));
        $orders = Order::findOrFail($callback->order_id);
        // dd($callback);

        if ($orders) {
            if (strtolower($callback->transaction_status) == 'pending') {
                $orders->status = 1;
            } elseif (strtolower($callback->transaction_status) == 'settlement' || strtolower($callback->transaction_status) == 'capture') {
                $orders->status = 2;
            } elseif (strtolower($callback->transaction_status) == 'deny' || strtolower($callback->transaction_status) ==  'cancel' || strtolower($callback->transaction_status) ==  'expire') {
                $orders->status = 5;

                $orderitems = OrderItem::where('order_id', $callback->order_id)->get();
                // dd($orderitems);
                foreach ($orderitems as $item) {
                    $product = Product::where('id', $item->prod_id)->first();
                    // dd($item->qty);
                    $product->stock = $product->stock + $item->qty;
                    $product->update();
                }
            }
            if (isset($callback->va_numbers)) {
                $orders->payment_code = $callback->va_numbers['0']->va_number;
            } else {
                $orders->payment_code = isset($callback->payment_code) ? $callback->payment_code : null;
            }

            if ($callback->payment_type = "bank_transfer") {
                $orders->payment_type = "Transfer Bank " . strtoupper(isset($callback->va_numbers['0']->bank));
            } else {
                $orders->payment_type = $callback->payment_type;
            }

            $orders->midtrans_status = $callback->transaction_status;
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

    public function notifications()
    {

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }

        $notif = $notif->getResponse();
        /** @var object $notif */
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        $orders = Order::findOrFail($order_id);

        if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            $orders->status = 2;
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $orders->status = 1;
        } else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            $orders->status = 5;

            $orderitems = OrderItem::where('order_id', $order_id)->get();
            foreach ($orderitems as $item) {
                $product = Product::where('id', $item->prod_id)->first();
                // dd($item->qty);
                $product->stock = $product->stock + $item->qty;
                $product->update();
            }
        }

        $orders->midtrans_status = $transaction;
        $orders->update();
    }
}
