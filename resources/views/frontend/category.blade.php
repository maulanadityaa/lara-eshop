@extends('layouts.front')

@section('title')
    Kategori
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-light text-dark">
        <div class="container">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > Semua Kategori</h5>
        </div>
    </div>
    <div class="mt-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Semua Kategori</h2>
                    <div class="row">
                        @foreach ($category as $item)
                            <div class="col-md-3 mb-3">
                                <a href="{{ url('view-category/' . $item->slug) }}">
                                    <div class="card">
                                        <img src="{{ asset('assets/uploads/category/' . $item->image) }}"
                                            alt="Category Image">
                                        <div class="card-body">
                                            <h5>{{ $item->name }}</h5>
                                            <p>{{ $item->description }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
