@extends('layouts.front')

@section('title')
    {{ $product->name }}
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-light text-dark">
        <div class="container">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > <a
                    href="{{ url('/view-category/' . $product->category->slug) }}">{{ $product->category->name }}</a> >
                {{ $product->name }}</h5>
        </div>
    </div>

    <div class="container">
        <div class="card shadow product_data">
            <div class="card-body">
                <div class="row">
                    {{-- menampilkan error validasi --}}
                    {{-- @php
                        dd($errors)
                    @endphp --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-md-4 border-right" id="img-product">
                        <img src="{{ asset('assets/uploads/product/' . $product->image) }}" class="w-100 rounded"
                            alt="Product Image">
                    </div>
                    <div class="col-md-8">
                        <h2 class="mb-0">
                            {{ $product->name }}
                            @if ($product->trending == '1')
                                <label style="font-size: 16px;" class="float-end badge bg-danger trending_tag">Produk
                                    Populer</label>
                            @endif
                        </h2>
                        <hr>

                        <label class="me-3">Harga Asli : <s>Rp.
                                {{ number_format($product->original_price) }}</s></label>
                        <label class="fw-bold">
                            <h4><strong>Rp. {{ number_format($product->sell_price) }}</strong></h4>
                        </label>
                        <p class="mt-3">{!! $product->description !!}
                            <br><br>
                            <strong>Ukuran Tersedia : {{ $product->size }}</strong>
                        </p>
                        <hr>

                        @if ($product->stock > 0)
                            <label class="badge bg-success">Tersedia</label>
                        @else
                            <label class="badge bg-danger">Stok Habis</label>
                        @endif

                        <div class="row mt-2">
                            <div class="col-md-3">
                                <input type="hidden" value="{{ $product->id }}" class="prod_id">
                                <label for="Jumlah">Jumlah</label>
                                <div class="input-group text-center mb-3" style="width: 130px;">
                                    <button class="input-group-text decrement-btn">-</button>
                                    <input type="text" name="jumlah" value="1" class="form-control qty-input text-center" />
                                    <button class="input-group-text increment-btn">+</button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                {{-- <input type="hidden" value="{{ $product->id }}" class="prod_id"> --}}
                                <label for="Jumlah">Ukuran</label>
                                <input type="number" name="size" value="" class="form-control prod_size text-center"
                                    required>
                            </div>
                            <div class="col-md-5">
                                {{-- <input type="hidden" value="{{ $product->id }}" class="prod_id"> --}}
                                <label for="Catatan">Catatan (optional)</label>
                                <textarea class="form-control note" name="catatan" rows="1" cols="1"></textarea>
                            </div>
                            <div class="col-md-10">
                                <br />
                                @if ($product->stock > 0)
                                    <button type="button" class="btn btn-primary me-3 addtoCartBtn float-start">Masukkan
                                        Keranjang <i class="fa fa-shopping-cart"></i></button>
                                @elseif($product->stock <= 0)
                                    <button type="button" class="btn btn-primary me-3 addtoCartBtn float-start"
                                        disabled>Masukkan
                                        Keranjang <i class="fa fa-shopping-cart"></i></button>
                                @endif
                                <button type="button" class="btn btn-success me-3 addtoWishlistBtn float-start">Tambahkan ke
                                    Wishlist <i class="fa fa-heart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var options = {
            width: 425,
            zoomWidth: 500,
            fillContainer: true,
            scale: 1.2,
            offset: {
                vertical: 0,
                horizontal: 10
            }
        };
        new ImageZoom(document.getElementById("img-product"), options);
    </script>
@endsection
