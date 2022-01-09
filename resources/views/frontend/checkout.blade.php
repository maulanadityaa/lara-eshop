@extends('layouts.front')

@section('title')
    Halaman Checkout
@endsection

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold">Detail Pengiriman</h5>
                        <hr>
                        <div class="row checkout-form">
                            <div class="col-md-6">
                                <label for="">Nama Depan</label>
                                <input type="text" class="form-control" name="" placeholder="Masukkan Nama Depan">
                            </div>
                            <div class="col-md-6">
                                <label for="">Nama Belakang</label>
                                <input type="text" class="form-control" name="" placeholder="Masukkan Nama Belakang">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Email</label>
                                <input type="text" class="form-control" name="" placeholder="Masukkan Email">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Nomor HP</label>
                                <input type="text" class="form-control" name="" placeholder="Masukkan Nama Belakang">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Alamat Lengkap</label>
                                <input type="text" class="form-control" name="" placeholder="Masukkan Alamat Lengkap">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Kota/Kabupaten</label>
                                <input type="text" class="form-control" name="" placeholder="Masukkan Nama Kota/Kabupaten">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Provinsi</label>
                                <input type="text" class="form-control" name="" placeholder="Masukkan Nama Provinsi">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Kode Pos</label>
                                <input type="number" class="form-control" name="" placeholder="Masukkan Kode Pos">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold">Detail Order</h5>
                        <hr>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartitems as $item)
                                    <tr>
                                        <td>{{ $item->products->name }}</td>
                                        <td>{{ $item->prod_qty }}</td>
                                        <td>Rp. {{ number_format($item->products->sell_price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <button class="btn btn-primary float-end">Buat Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection