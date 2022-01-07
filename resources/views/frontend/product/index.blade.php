@extends('layouts.front')

@section('title')
    {{ $category->name }}
@endsection

@section('content')
    @include('layouts.inc.slider')

    <div class="py-5">
        <div class="container">
            <div class="row">
                <h2><strong>{{ $category->name }}</strong></h2>
                <hr>
                @foreach ($products as $product)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <a href="{{ url('view-category/'.$category->slug.'/'.$product->slug) }}">
                                <img src="{{ asset('assets/uploads/product/' . $product->image) }}" class="w-100" alt="Trending Image">
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
@endsection
