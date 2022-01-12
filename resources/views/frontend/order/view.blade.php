@extends('layouts.front')

@section('title')
    Pesanan Saya
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-secondary text-white">
        <div class="container">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > Pesanan Saya</h5>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3 class="text-center text-dark"><strong>Detail Pesanan</strong></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 order-details">
                                <h3><strong>Detail Pengiriman</strong></h3>
                                <hr>
                                <label for="">Nama Depan</label>
                                <div class="border">{{ $orders->fname }}</div>
                                <label for="">Nama Belakang</label>
                                <div class="border">{{ $orders->lname }}</div>
                                <label for="">Email</label>
                                <div class="border">{{ $orders->email }}</div>
                                <label for="">No HP</label>
                                <div class="border">{{ $orders->nohp }}</div>
                                <label for="">Alamat Pengiriman</label>
                                <div class="border">{{ $orders->address }}, {{ $orders->city }},
                                    {{ $orders->province }}, {{ $orders->postal_code }}</div>
                            </div>
                            <div class="col-md-6">
                                <h3><strong>Detail Barang</strong></h3>
                                <hr>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th><strong>Nama Produk</strong></th>
                                            <th><strong>Jumlah</strong></th>
                                            <th><strong>Harga</strong></th>
                                            <th><strong>Gambar</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders->orderitems as $item)
                                            <tr>
                                                {{-- @php
                                                    dd($item);
                                                @endphp --}}
                                                <td>{{ $item->products->name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>Rp. {{ number_format($item->price) }}</td>
                                                <td>
                                                    <img src="{{ asset('assets/uploads/product/' . $item->products->image) }}"
                                                        width="50px" alt="Gambar Produk">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <h4 class="px-2">Total Harga : <span class="float-end"><strong>Rp. {{ number_format($orders->total_price) }}</strong></span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
