@extends('layouts.front')

@section('title')
    Keranjangku
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-secondary text-white">
        <div class="container">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > Keranjang</h5>
        </div>
    </div>

    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                @foreach ($cartitems as $item)
                    <div class="row product_data">
                        <div class="col-md-2">
                            <img src="{{ asset('assets/uploads/product/'.$item->products->image) }}" height="70px" width="70px" alt="Gambar produk">
                        </div>
                        <div class="col-md-5">
                            <h4>{{ $item->products->name }}</h4>
                        </div>
                        <div class="col-md-3">
                            <input type="hidden" value="{{ $item->prod_id }}" class="prod_id">
                            <label for="Jumlah">Jumlah</label>
                            <div class="input-group text-center mb-3" style="width: 130px;">
                                <button class="input-group-text decrement-btn">-</button>
                                <input type="text" name="jumlah" value="1" class="form-control qty-input text-center" value="{{ $item->prod_qty }}">
                                <button class="input-group-text increment-btn">+</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger deleteCartItem"><i class="fa fa-trash"></i> Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
