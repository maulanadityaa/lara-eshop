@extends('layouts.front')

@section('title')
    Semua Produk
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-light text-dark">
        <div class="container-xxl">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > Semua Produk</h5>
        </div>
    </div>
    <div class="py-1">
        <div class="container-xxl">
            <div class="row">
                <div class="col-md-12">
                    <h2>Semua Produk</h2>
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-3 mt-3">
                                <div class="card h-100">
                                    <img src="{{ asset('assets/uploads/product/' . $product->image) }}"
                                        class="card-img-top" height="300px" alt="Product Image">
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
        </div>
    </div>
@endsection
