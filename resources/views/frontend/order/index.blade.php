@extends('layouts.front')

@section('title')
    Pesanan Saya
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-light text-dark">
        <div class="container">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > Pesanan Saya</h5>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h3 class="card-header text-center text-white" style="background: rgb(170, 79, 255)">
                        Pesanan Saya
                    </h3>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover" style="cursor:pointer">
                            <thead class="table-dark">
                                <tr class="text-center">
                                    <th><strong>Invoice ID</strong></th>
                                    <th><strong>Metode Pembayaran</strong></th>
                                    <th><strong>Kode Bayar</strong></th>
                                    <th><strong>No. Resi</strong></th>
                                    <th><strong>Total Harga</strong></th>
                                    <th><strong>Status</strong></th>
                                    <th><strong>Aksi/Keterangan</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $item)
                                    <tr class="text-center clickable-row"
                                        data-href='{{ url('view-order/' . $item->id) }}'>
                                        <td class="text-center">
                                            <p class="h5">
                                                {{ $item->id }}
                                            </p>
                                            <small>
                                                {{ date('d F Y H:i:s', strtotime($item->created_at)) }} WIB
                                            </small>
                                        </td>
                                        @if (!$item->payment_type)
                                            <td>Belum Memilih Pembayaran</td>
                                        @elseif ($item->payment_type == 'cstore')
                                            <td style="text-transform:uppercase">Alfamart/Indomaret</td>
                                        @else
                                            <td style="text-transform:uppercase">{{ $item->payment_type }}</td>
                                        @endif
                                        @if (!$item->payment_code)
                                            <td>Kode Bayar Tidak Tersedia</td>
                                        @else
                                            <td>{{ $item->payment_code }}</td>
                                        @endif
                                        @if ($item->noresi == '0')
                                            <td>Belum Tersedia</td>
                                        @else
                                            <td>{{ $item->noresi }}</td>
                                        @endif
                                        <td>Rp. {{ number_format($item->total_price) }}</td>
                                        @if ($item->status == '0')
                                            <td><span class="badge bg-danger text-white">Menunggu Konfirmasi</span></td>
                                        @elseif($item->status == '1')
                                            <td><span class="badge bg-warning text-white">Menunggu Pembayaran</span></td>
                                        @elseif($item->status == '2')
                                            <td><span class="badge bg-primary">Telah Dibayar</span></td>
                                        @elseif ($item->status == '3')
                                            <td><span class="badge bg-info text-dark">Sedang dikirm</span></td>
                                        @elseif ($item->status == '4')
                                            <td><span class="badge bg-success">Selesai</span></td>
                                        @else
                                            <td><span class="badge bg-danger">Dibatalkan</span></td>
                                        @endif
                                        <td>
                                            @if ($item->status == '0')
                                            @elseif ($item->midtrans_status == null)

                                            @elseif ($item->status == '5')
                                                <div class="text-danger">Pesanan Dibatalkan</div>
                                                @if ($item->midtrans_status == 'deny' || $item->midtrans_status == 'cancel')
                                                    <p class="text-muted fw-lighter">(Pembayaran Gagal)</p>
                                                @elseif ($item->midtrans_status == 'expire')
                                                    <p class="text-muted fw-lighter">(Pembayaran melebihi batas waktu)</p>
                                                @endif
                                            @else
                                                <a href="{{ url('view-order/update-status/' . $item->id) }}"
                                                    class="btn btn-primary" name="update_status">Update Status</a>
                                            @endif
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

@section('scripts')
    <script>
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    </script>
@endsection
