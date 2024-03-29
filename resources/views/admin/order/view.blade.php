@extends('layouts.admin')

@section('title')
    Detail Pesanan
@endsection

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-nav-tabs">
                    <div class="card-header card-header-warning">
                        <h3 class="card-title">Detail Pesanan</h3>
                        {{-- <a href="{{ url('admin/orders') }}" class="btn btn-dark float-right">Kembali</a> --}}
                        <h4 class="card-category">INVOICE ID : {{ $orders->id }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 order-details">
                                <h3><strong>Detail Pengiriman</strong></h3>
                                <hr>
                                <label for="">Nama Depan</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{ $orders->fname }}">
                                </div>
                                <label for="">Nama Belakang</label>
                                {{-- <div class="border">{{ $orders->lname }}</div> --}}
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{ $orders->lname }}">
                                </div>
                                <label for="">Email</label>
                                {{-- <div class="border">{{ $orders->email }}</div> --}}
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{ $orders->email }}">
                                </div>
                                <label for="">No HP</label>
                                {{-- <div class="border">{{ $orders->nohp }}</div> --}}
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{ $orders->nohp }}">
                                </div>
                                <label for="">Alamat Pengiriman</label>
                                {{-- <div class="border">{{ $orders->address }}, {{ $orders->city }},
                                    {{ $orders->province }}, {{ $orders->postal_code }}</div> --}}
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control"
                                        value="{{ $orders->address }}, {{ $city->name }}, {{ $province->name }}">
                                </div>
                                <label for="">Kode POS</label>
                                {{-- <div class="border">{{ $orders->address }}, {{ $orders->city }},
                                    {{ $orders->province }}, {{ $orders->postal_code }}</div> --}}
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{ $orders->postal_code }}">
                                </div>
                                <label for="">Jasa Ekspedisi</label>
                                {{-- <div class="border">{{ $orders->courier }}</div> --}}
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{ $orders->courier }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3><strong>Detail Barang</strong></h3>
                                <hr>
                                <div class="table table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr class="text-center">
                                                <th><strong>Nama Produk</strong></th>
                                                <th><strong>Jumlah</strong></th>
                                                <th><strong>Ukuran</strong></th>
                                                <th><strong>Harga</strong></th>
                                                <th><strong>Catatan</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders->orderitems as $item)
                                                <tr>
                                                    <td>{{ $item->products->name }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ $item->prod_size }}</td>
                                                    <td>Rp. {{ number_format($item->price) }}</td>
                                                    <td>{{ $item->message }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <h5 class="px-2">Ongkir<span class="float-right">Rp.
                                        {{ number_format($orders->ongkir) }}</span></h5>
                                <hr>
                                <h3 class="px-2">Total Harga<span class="float-right"><b><strong>Rp.
                                                {{ number_format($orders->total_price) }}</strong></b></span></h3>
                                <div class="mt-5 px-2">
                                    <form action="{{ url('admin/update-order/' . $orders->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon3">Nomor Resi</span>
                                            <input type="text" class="form-control" value="{{ $orders->noresi }}"
                                                name="no_resi">
                                        </div>
                                        <div class="input-group">
                                            <label for="status">Status : </label>
                                            <select class="form-select" name="order_status">
                                                <option {{ $orders->status == '0' ? 'selected' : '' }} value="0">Menunggu
                                                    Konfirmasi</option>
                                                <option {{ $orders->status == '1' ? 'selected' : '' }} value="1">Menunggu
                                                    Pembayaran</option>
                                                <option {{ $orders->status == '2' ? 'selected' : '' }} value="2">Telah
                                                    Dibayar
                                                </option>
                                                <option {{ $orders->status == '3' ? 'selected' : '' }} value="3">Sedang
                                                    Dikirim
                                                </option>
                                                <option {{ $orders->status == '4' ? 'selected' : '' }} value="4">Selesai
                                                </option>
                                                <option {{ $orders->status > '5' ? 'selected' : '' }} value="5">
                                                    Dibatalkan
                                                </option>
                                            </select>
                                            <button type="submit" class="btn btn-primary mt-3 float-right">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
