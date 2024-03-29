@extends('layouts.front')

@section('title')
    Selamat Datang di Byboot.id
@endsection

@section('content')
    @include('layouts.inc.slider')
    <div class="py-5">
        <div class="container-xxl">
            <div class="row">
                <h2>Produk Populer</h2>
                <div class="owl-carousel owl-theme">
                    @foreach ($featured_products as $product)
                        <div class="card h-100">
                            <img src="{{ asset('assets/uploads/product/' . $product->image) }}" class="card-img-top"
                                height="300px" alt="Product Image">
                            <a class="stretched-link"
                                href="{{ url('view-category/' . $product->category->slug . '/' . $product->slug) }}">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <div>
                                    <h5>{{ $product->name }}</h5>
                                </div>
                                <div class="mt-auto">
                                    <span class="float-end"><s>Rp.
                                            {{ number_format($product->original_price) }}</s></span>
                                    <span class="float-start"><strong>Rp.
                                            {{ number_format($product->sell_price) }}</strong></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="container-xxl">
            <div class="row">
                <a href="{{ url('/all-products') }}">
                    <h2>Semua Produk</h2>
                </a>
                @foreach ($products as $product)
                    <div class="col-md-3 mt-3">
                        <div class="card h-100">
                            <img src="{{ asset('assets/uploads/product/' . $product->image) }}" class="card-img-top"
                                height="300px" alt="Product Image">
                            <a class="stretched-link"
                                href="{{ url('view-category/' . $product->category->slug . '/' . $product->slug) }}">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <div>
                                    <h5>{{ $product->name }}</h5>
                                </div>
                                <div class="mt-auto">
                                    <span class="float-end"><s>Rp.
                                            {{ number_format($product->original_price) }}</s></span>
                                    <span class="float-start"><strong>Rp.
                                            {{ number_format($product->sell_price) }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination mt-5 justify-content-center">
                <div class="d-flex">
                    {!! $products->links() !!}
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
