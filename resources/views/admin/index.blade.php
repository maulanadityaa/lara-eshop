@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
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
                            <i class="material-icons text-warning">warning</i>Ada {{ $orders_unconfirmed }} Pesanan Baru
                            yang belum dikonfirmasi
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
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
                            <i class="material-icons text-success">check_circle</i> {{ $orders_confirmed }} pesanan sudah
                            diproses
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">cancel</i>
                        </div>
                        <p class="card-category">Pesanan Dibatalkan</p>
                        <h1 class="card-title">{{ $orders_canceled }}</h1>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-danger">cancel</i> {{ $orders_canceled }} pesanan dibatalkan
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
                                <th class="text-center">Invoice ID</th>
                                <th>Hubungi WhatsApp</th>
                                <th>Email</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($orders as $item)
                                    <tr>
                                        <td class="text-center">
                                            <p class="h4">
                                                {{ $item->id }}
                                            </p>
                                            <small>
                                                {{ date('d F Y H:i:s', strtotime($item->created_at)) }} WIB
                                            </small>
                                        </td>
                                        <td><a href="https://wa.me/{{ $item->nohp }}" target="_blank"
                                                style="color: green"><i class="material-icons">whatsapp</i>
                                                {{ $item->nohp }}</a></td>
                                        <td>{{ $item->email }}</td>
                                        <td>Rp. {{ number_format($item->total_price) }}</td>
                                        <td><span class="badge bg-danger text-white">Menunggu Konfirmasi</span></td>
                                        <td class="text-center">
                                            <a href="{{ url('admin/confirm-order/' . $item->id) }}"
                                                class="btn btn-success">Accept</a>
                                            <a href="{{ url('admin/decline-order/' . $item->id) }}"
                                                class="btn btn-danger">Decline</a>
                                            <a href="{{ url('admin/view-order-details/' . $item->id) }}"
                                                class="btn btn-info">Lihat</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination justify-content-center">
                        <div class="d-flex">
                            {!! $orders->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
