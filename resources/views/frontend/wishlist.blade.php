@extends('layouts.front')

@section('title')
    Wishlist Saya
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-light text-dark">
        <div class="container">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > Wishlist</h5>
        </div>
    </div>

    <div class="container">
        <div class="card shadow">
            <h3 class="card-header text-center text-white" style="background: rgb(255, 90, 206)">
                Wishlist Saya
            </h3>
            <div class="card-body">
                @if ($wishlist->count() > 0)
                    <div class="card-body">
                        @foreach ($wishlist as $item)
                            <div class="row product_data table-hover">
                                <div class="col-md-2 my-auto">
                                    <img src="{{ asset('assets/uploads/product/' . $item->products->image) }}"
                                        height="70px" width="70px" alt="Gambar produk">
                                </div>
                                <div class="col-md-2 my-auto clickable-name"
                                    data-href='{{ url('view-category/' . $item->products->category->slug . '/' . $item->products->slug) }}' style="cursor:pointer">
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
                                    @if ($item->products->stock > 0)
                                        <h6 class="badge bg-success">Stok Tersedia</h6>
                                    @else
                                        <h6 class="badge bg-danger">Stok Habis</h6>
                                    @endif
                                </div>
                                <div class="col-md-2 my-auto">
                                    <button class="btn btn-danger deleteWishlistItem"><i class="fa fa-trash"></i>
                                        Delete</button>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                @else
                    <h4 class="text-center">Tidak Ada Produk di Wishlist Kamu</h4>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(".clickable-name").click(function() {
            window.location = $(this).data("href");
        });
    </script>
@endsection