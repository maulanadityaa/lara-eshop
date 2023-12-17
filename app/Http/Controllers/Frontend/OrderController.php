<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Order;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PDF;

class OrderController extends Controller
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

        if ($orders) {
            $cityId = $orders->city;
            $city = City::where('city_id', '=', $cityId)->first();
            $provinceId = $orders->province;
            $province = Province::where('province_id', '=', $provinceId)->first();
        }

        return view('frontend.order.view', compact('orders', 'province', 'city'));
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

    public function checkAwb($id)
    {
        $orders = Order::where('id', $id)->where('user_id', Auth::id())->first();

        if ($orders) {
            $noresi = $orders->noresi;
            $apiKey = '9e8b0d51a60d4a63f3bb9ab8b8d3b7f3855ea6bd7eaf7d67cf16142f8acdc5bf';

            $response = Http::get('https://api.binderbyte.com/v1/track?api_key=' . $apiKey . '&courier=jnt&awb=JP5431695388');

            dd($response->json());
        }
    }
}
