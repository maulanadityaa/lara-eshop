@extends('layouts.front')

@section('title')
    {{ $category->name }}
@endsection

@section('content')
    <div class="py-3 shadow-sm bg-light text-dark">
        <div class="container-xxl">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > {{ $category->name }}</h5>
        </div>
    </div>

    <div class="mt-4">
        <div class="container-xxl">
            <div class="row">
                <h2><strong>{{ $category->name }}</strong></h2>
                <hr>
                @foreach ($products as $product)
                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <a href="{{ url('view-category/' . $category->slug . '/' . $product->slug) }}"
                                class="stretched-link"></a>
                            <img src="{{ asset('assets/uploads/product/' . $product->image) }}" class="w-100"
                                alt="Trending Image">
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
        </div>
    </div>
@endsection
