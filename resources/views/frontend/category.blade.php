@extends('layouts.front')

@section('title')
    Kategori
@endsection

@section('content')
    @include('layouts.inc.slider')

    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Semua Kategori</h2>
                    <div class="row">
                        @foreach ($category as $item)
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <img src="{{ asset('assets/uploads/category/'.$item->image) }}" alt="Category Image">
                                    <div class="card-body">
                                        <h5>{{ $item->name }}</h5>
                                        <p>{{ $item->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection