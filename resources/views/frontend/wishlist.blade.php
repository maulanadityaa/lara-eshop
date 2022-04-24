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
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr class="text-center">
                                    <th><strong>Gambar</strong></th>
                                    <th><strong>Nama Produk</strong></th>
                                    <th><strong>Harga</strong></th>
                                    <th><strong>Stok</strong></th>
                                    <th><strong>Aksi</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wishlist as $item)
                                    <tr class="product_data text-center">
                                        <td class="text-center">
                                            <img src="{{ asset('assets/uploads/product/' . $item->products->image) }}"
                                                height="70px" width="70px" alt="Gambar produk">
                                        </td>
                                        <td class="col-md-2 my-auto clickable-name"
                                            data-href='{{ url('view-category/' . $item->products->category->slug . '/' . $item->products->slug) }}'
                                            style="cursor:pointer">
                                            <h5>{{ $item->products->name }}</h5>
                                        </td>
                                        <td>
                                            <h5>Rp. {{ number_format($item->products->sell_price) }}</h5>
                                        </td>
                                        <td>
                                            <input type="hidden" value="{{ $item->prod_id }}" class="prod_id">
                                            @if ($item->products->stock > 0)
                                                <h6 class="badge bg-success">Stok Tersedia</h6>
                                            @else
                                                <h6 class="badge bg-danger">Stok Habis</h6>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-danger deleteWishlistItem"><i class="fa fa-trash"></i>
                                                Delete</button>
                    </div>
                    </tr>
                @endforeach
                </tbody>
                </table>

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
