@extends('layouts.front')

@section('title')
    Selamat Datang di Toko Sandal
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
                            <div class="card">
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

    <div class="py-5">
        <div class="container">
            <div class="row">
                <h2>Kategori Populer</h2>
                <div class="owl-carousel owl-theme">
                    @foreach ($featured_categories as $cate)
                        <div class="item">
                            <a href="{{ url('/view-category/' . $cate->slug) }}">
                                <div class="card">
                                    <img src="{{ asset('assets/uploads/category/' . $cate->image) }}"
                                        class="product-img" alt="Trending Image">
                                    <div class="card-body">
                                        <h5>{{ $cate->name }}</h5>
                                        <p>{{ $cate->description }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
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
