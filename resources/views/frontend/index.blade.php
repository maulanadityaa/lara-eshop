@extends('layouts.front')

@section('title')
    Selamat Datang di Byboot.id
@endsection

@section('content')
    @include('layouts.inc.slider')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <h2>Produk Populer</h2>
                <div class="owl-carousel owl-theme">
                    @foreach ($featured_products as $product)
                        <div class="item">
                            <div class="card h-100">
                                <a href="{{ url('view-category/' . $product->category->slug . '/' . $product->slug) }}">
                                    <img src="{{ asset('assets/uploads/product/' . $product->image) }}"
                                        class="product-img" alt="Trending Image">
                                    <div class="card-body">
                                        <h5>{{ $product->name }}</h5>
                                        <span class="float-end"><s>Rp.
                                                {{ number_format($product->original_price) }}</s></span>
                                        <span class="float-start"><strong>Rp.
                                                {{ number_format($product->sell_price) }}</strong></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="container">
            <div class="row">
                <h2>Semua Produk</h2>
                @foreach ($products as $product)
                    <div class="col-md-3 mt-3">
                        <div class="card h-100">
                            <a href="{{ url('view-category/' . $product->category->slug . '/' . $product->slug) }}">
                                <img src="{{ asset('assets/uploads/product/' . $product->image) }}" class="card-img-top"
                                    height="300px" alt="Product Image">
                                <div class="card-body">
                                    <h5>{{ $product->name }}</h5>
                                    <span class="float-end"><s>Rp.
                                            {{ number_format($product->original_price) }}</s></span>
                                    <span class="float-start"><strong>Rp.
                                            {{ number_format($product->sell_price) }}</strong></span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination mt-3 justify-content-center">
                <div class="d-flex">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
    {{ \TawkTo::widgetCode() }}
@endsection

@section('scripts')
    <script>
        $('.owl-carousel').owlCarousel({
            loop: false,
            margin: 10,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        })
    </script>
@endsection
