@extends('layouts.front')

@section('title')
    {{ $product->name }}
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-secondary text-white">
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
                    <div class="col-md-4 border-right">
                        <img src="{{ asset('assets/uploads/product/' . $product->image) }}" class="w-100"
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
                            <div class="col-md-3">
                                <input type="hidden" value="{{ $product->id }}" class="prod_id">
                                <label for="Jumlah">Jumlah</label>
                                <div class="input-group text-center mb-3" style="width: 130px;">
                                    <button class="input-group-text decrement-btn">-</button>
                                    <input type="text" name="jumlah" value="1" class="form-control qty-input text-center" />
                                    <button class="input-group-text increment-btn">+</button>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <br />
                                <button type="button" class="btn btn-success me-3 float-start">Tambahkan ke
                                    Wishlist <i class="fa fa-heart"></i></button>
                                <button type="button" class="btn btn-primary me-3 addtoCartBtn float-start">Masukkan
                                    Keranjang <i class="fa fa-shopping-cart"></i></button>
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
        $('document').ready(function() {
            $('.addtoCartBtn').click(function(e) {
                e.preventDefault();

                var product_id = $(this).closest('.product_data').find('.prod_id').val();
                var product_qty = $(this).closest('.product_data').find('.qty-input').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/add-to-cart",
                    data: {
                        'product_id': product_id,
                        'product_qty': product_qty
                    },
                    success: function(response) {
                        swal(response.status);
                    }
                });
            });

            $('.decrement-btn').click(function(e) {
                e.preventDefault();

                var dec_value = $('.qty-input').val();
                var value = parseInt(dec_value, 15);
                value = isNaN(value) ? 0 : value;

                if (value > 1) {
                    value--;
                    $('.qty-input').val(value);
                }
            });

            $('.increment-btn').click(function(e) {
                e.preventDefault();

                var inc_value = $('.qty-input').val();
                var value = parseInt(inc_value, 15);
                value = isNaN(value) ? 0 : value;

                if (value < 15) {
                    value++;
                    $('.qty-input').val(value);
                }
            });
        });
    </script>
@endsection
