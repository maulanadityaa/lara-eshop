@extends('layouts.front')

@section('title')
    Keranjangku
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-light text-dark">
        <div class="container-xxl">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > Keranjang</h5>
        </div>
    </div>

    <div class="container-xxl">
        <div class="card shadow">
            <h3 class="card-header text-center text-white bg-primary">
                Keranjang Saya
            </h3>
            @if ($cartitems->count() > 0)
                <div class="card-body table-responsive">
                    @php
                        $total = 0;
                    @endphp
                    <table class="table table-hover">
                        <tbody>
                            @foreach ($cartitems as $item)
                                <tr class="row product_data">
                                    <td class="col">
                                        <img src="{{ asset('assets/uploads/product/' . $item->products->image) }}"
                                            height="70px" width="70px" alt="Gambar produk">
                                    </td>
                                    <td class="col">
                                        <h5>{{ $item->products->name }}</h5>
                                    </td>
                                    <td class="col">
                                        <h5>{{ $item->prod_size }}</h5>
                                    </td>
                                    <td class="col">
                                        <h5>Rp. {{ number_format($item->products->sell_price) }}</h5>
                                    </td>
                                    <td class="col">
                                        <small>Catatan : </small>
                                        <textarea class="form-control changeNote">{{ $item->message }}</textarea>
                                    </td>
                                    <td class="col">
                                        <input type="hidden" value="{{ $item->prod_id }}" class="prod_id">
                                        @if ($item->products->stock >= $item->prod_qty)
                                            <small>Jumlah : </small>
                                            <div class="input-group text-center mb-3" style="width: 130px;">
                                                <button class="input-group-text changeQty decrement-btn">-</button>
                                                <input type="text" name="jumlah" value="{{ $item->prod_qty }}"
                                                    class="form-control qty-input text-center"
                                                    value="{{ $item->prod_qty }}">
                                                <button class="input-group-text changeQty increment-btn">+</button>
                                            </div>
                                            @php
                                                $total += $item->products->sell_price * $item->prod_qty;
                                            @endphp
                                        @else
                                            <h6 class="badge bg-danger">Stok Habis</h6>
                                        @endif
                                    </td>
                                    <td class="col">
                                        <button class="btn btn-danger deleteCartItem"><i class="fa fa-trash"></i>
                                            Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <h4 class="my-auto">Total Harga : Rp. {{ number_format($total) }}
                        <a href="{{ url('checkout') }}" class="btn btn-success float-end">Checkout</a>
                    </h4>
                </div>
            @else
                <div class="card-body text-center">
                    <h3>Keranjang <i class="fa fa-shopping-cart"></i> kamu sedang kosong</h3>
                    <a href="{{ url('category') }}" class="btn btn-outline-success float-end">Belanja Sekarang</a>
                </div>
            @endif
        </div>
    </div>
@endsection
