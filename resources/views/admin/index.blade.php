@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">receipt</i>
                        </div>
                        <p class="card-category">Pesanan Baru</p>
                        <h1 class="card-title">{{ $orders_unconfirmed }}</h1>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-danger">warning</i>
                            <a href="#">Ada {{ $orders_unconfirmed }} Pesanan Baru yang belum dikonfirmasi</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">confirmation_number</i>
                        </div>
                        <p class="card-category">Pesanan Dikonfirmasi</p>
                        <h1 class="card-title">{{ $orders_confirmed }}</h1>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> {{ $orders_confirmed }} pesanan sudah <diproses></diproses>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h3 class="card-title">Pesanan Baru</h3>
                        <p class="card-category">Pesanan yang belum dikonfirmasi</p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                                <th>INVOICE ID</th>
                                <th>Tanggal Pemesanan</th>
                                <th>Email</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($orders as $item)
                                    <tr>
                                        <td>{{ $item->invoice_id }}</td>
                                        <td>{{ date('d F Y H:i:s', strtotime($item->created_at)) }} WIB</td>
                                        <td>{{ $item->email }}</td>
                                        <td>Rp. {{ number_format($item->total_price) }}</td>
                                        <td><span class="badge bg-danger text-white">Menunggu Konfirmasi</span></td>
                                        <td>
                                            <a href="{{ url('admin/view-order-details/' . $item->id) }}"
                                                class="btn btn-info">Lihat</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
