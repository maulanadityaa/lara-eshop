@extends('layouts.front')

@section('title')
    {{ $product->name }}
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-secondary text-white border-top">
        <div class="container">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > <a
                    href="{{ url('/view-category/' . $product->category->slug) }}">{{ $product->category->name }}</a> >
                {{ $product->name }}</h5>
        </div>
    </div>

    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 border-right">
                        <img src="{{ asset('assets/uploads/product/' . $product->image) }}" class="w-100"
                            alt="Product Image">
                    </div>
                    <div class="col-md-8">
                        <h2 class="mb-0">
                            {{ $product->name }}
                            @if ($product->trending == '1')
                                <label style="font-size: 16px;"
                                    class="float-end badge bg-danger trending_tag">Produk Populer</label>
                            @endif
                        </h2>
                        <hr>

                        <label class="me-3">Harga Asli : <s>Rp.
                                {{ number_format($product->original_price) }}</s></label>
                        <label class="fw-bold">Harga Sekarang : Rp.
                            {{ number_format($product->sell_price) }}</label>
                        <p class="mt-3">{!! $product->description !!}</p>
                        <hr>

                        @if ($product->stock > 0)
                            <label class="badge bg-success">Tersedia</label>
                        @else
                            <label class="badge bg-success">Stok Habis</label>
                        @endif

                        <div class="row mt-2">
                            <div class="col-md-2">
                                <label for="Jumlah">Jumlah</label>
                                <div class="input-group text-center mb-3">
                                    <span class="input-group-text">-</span>
                                    <input type="text" name="jumlah" value="1" class="form-control" />
                                    <span class="input-group-text">+</span>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <br />
                                <button type="button" class="btn btn-success me-3 float-start">Tambahkan ke
                                    Wishlist</button>
                                <button type="button" class="btn btn-primary me-3 float-start">Masukkan Keranjang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
