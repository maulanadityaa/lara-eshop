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
                    <div class="card-header">
                        <h3 class="text-center"><strong>Pesanan Saya</strong></h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><strong>No. Resi</strong></th>
                                    <th><strong>Total Harga</strong></th>
                                    <th><strong>Status</strong></th>
                                    <th><strong>Aksi</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $item)
                                    <tr class="text-center">
                                        <td>{{ $item->noresi }}</td>
                                        <td>{{ $item->total_price }}</td>
                                        @if ($item->status == '0')
                                            <td><span class="badge bg-warning text-dark">Menunggu Pembayaran</span></td>
                                        @elseif($item->status == '1')
                                            <td><span class="badge bg-primary">Telah Dibayar</span></td>
                                        @elseif ($item->status == '2')
                                            <td><span class="badge bg-info text-dark">Sedang dikirm</span></td>
                                        @elseif ($item->status == '3')
                                            <td><span class="badge bg-success">Selesai</span></td>
                                        @else
                                            <td><span class="badge bg-danger">Dibatalkan</span></td>
                                        @endif
                                        <td>
                                            <a href="{{ url('view-order/'.$item->id) }}" class="btn btn-info">Lihat</a>
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
