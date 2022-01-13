@extends('layouts.admin')

@section('title')
    Data Pesanan
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="text-center text-white my-auto"><strong>Pesanan Baru</strong>
                        <a href="{{ url('admin/order-history') }}" class="btn btn-warning float-right">Semua Pesanan</a></h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center fw-bold">
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
                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        @if ($item->noresi == '0')
                                            <td>Belum Ada</td>
                                        @else
                                            <td>{{ $item->noresi }}</td>
                                        @endif
                                        <td>Rp. {{ number_format($item->total_price) }}</td>
                                        <td><span class="badge bg-warning text-dark">Menunggu Pembayaran</span></td>
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
