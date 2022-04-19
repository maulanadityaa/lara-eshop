@extends('layouts.admin')

@section('title')
    Data Pesanan
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-nav-tabs">
                    <h3 class="card-header card-header-info">
                        Pesanan Baru
                        <a href="{{ url('admin/order-history') }}" class="btn btn-warning float-right">Semua Pesanan</a></h3>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-center fw-bold">
                                    <th><strong>INVOICE ID</strong></th>
                                    <th><strong>Tanggal Pemesanan</strong></th>
                                    <th><strong>No. Resi</strong></th>
                                    <th><strong>Total Harga</strong></th>
                                    <th><strong>Status</strong></th>
                                    <th><strong>Aksi</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $item)
                                    <tr class="text-center">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ date('d F Y H:i:s', strtotime($item->created_at)) }} WIB</td>
                                        @if ($item->noresi == '0')
                                            <td>Belum Ada</td>
                                        @else
                                            <td>{{ $item->noresi }}</td>
                                        @endif
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
