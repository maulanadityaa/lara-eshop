@extends('layouts.front')

@section('title')
    Keranjangku
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-light text-dark">
        <div class="container">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > Keranjang</h5>
        </div>
    </div>

    <div class="container">
        <div class="card shadow">
            <h3 class="card-header text-center text-white" style="background: rgb(90, 120, 255)">
                Keranjang Saya
            </h3>
            @if ($cartitems->count() > 0)
                <div class="card-body">
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($cartitems as $item)
                        <div class="row product_data">
                            <div class="col-md-2 my-auto">
                                <img src="{{ asset('assets/uploads/product/' . $item->products->image) }}" height="70px"
                                    width="70px" alt="Gambar produk">
                            </div>
                            <div class="col-md-2 my-auto">
                                <h5>{{ $item->products->name }}</h5>
                            </div>
                            <div class="col-md-2 my-auto">
                                <h5>{{ $item->prod_size }}</h5>
                            </div>
                            <div class="col-md-2 my-auto">
                                <h5>Rp. {{ number_format($item->products->sell_price) }}</h5>
                            </div>
                            <div class="col-md-2 my-auto">
                                <input type="hidden" value="{{ $item->prod_id }}" class="prod_id">
                                @if ($item->products->stock >= $item->prod_qty)
                                    <label for="Jumlah">Jumlah</label>
                                    <div class="input-group text-center mb-3" style="width: 130px;">
                                        <button class="input-group-text changeQty decrement-btn">-</button>
                                        <input type="text" name="jumlah" value="{{ $item->prod_qty }}"
                                            class="form-control qty-input text-center" value="{{ $item->prod_qty }}">
                                        <button class="input-group-text changeQty increment-btn">+</button>
                                    </div>
                                    @php
                                        $total += $item->products->sell_price * $item->prod_qty;
                                    @endphp
                                @else
                                    <h6 class="badge bg-danger">Stok Habis</h6>
                                @endif
                            </div>
                            <div class="col-md-2 my-auto">
                                <button class="btn btn-danger deleteCartItem"><i class="fa fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    @endforeach
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
