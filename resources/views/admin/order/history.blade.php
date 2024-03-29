@extends('layouts.admin')

@section('title')
    Data Semua Pesanan
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-nav-tabs">
                    {{-- <div class="card-header card-nav-tabs">
                        <h3 class="text-center text-dark  my-auto"><strong>Semua Pesanan</strong>
                        <a href="{{ url('admin/orders') }}" class="btn btn-primary float-right">Kembali</a></h3>
                    </div> --}}
                    <h3 class="card-header card-header-warning">
                        Semua Pesanan
                        <a href="{{ url('admin/orders') }}" class="btn btn-primary float-right">Kembali</a>
                    </h3>
                    <div class="container-fluid text-center">
                        <form class="row my-4" method="GET">
                            <div class="col mx-auto my-auto">
                                <h5>Filter Pencarian :</h5>
                            </div>
                            <div class="col">
                                <select name="month" class="form-select filterMonth">
                                    <option value="">Semua Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col">
                                <input name="keyword" value="{{ request('keyword') }}" type="search"
                                    class="form-control" placeholder="Search invoice id...">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary"><span class="material-icons">
                                        search
                                    </span></button>
                            </div>
                        </form>
                        <hr>
                        <form class="row my-auto text-center" action="{{ url('admin/order-history/print-report') }}"
                            method="post">
                            @csrf
                            <div class="col mx-auto my-auto">
                                <h5>Print Laporan Penjualan :</h5>
                            </div>
                            <div class="col">
                                <select name="month_print" class="form-select filterMonth">
                                    <option value="">---Pilih Bulan Penjualan---</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-danger text-white" name="btn_month_print"
                                    disabled><span class="material-icons">
                                        print
                                    </span></button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr class="text-center fw-bold">
                                    <th><strong>Invoice ID</strong></th>
                                    <th><strong>Metode Pembayaran</strong></th>
                                    <th><strong>No. Resi</strong></th>
                                    <th><strong>Total Harga</strong></th>
                                    <th><strong>Status</strong></th>
                                    <th><strong>Aksi</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->count() > 0)
                                    @foreach ($orders as $item)
                                        <tr class="text-center">
                                            <td class="text-center">
                                                <h4>{{ $item->id }}</h4>
                                                <small>
                                                    {{ date('d F Y H:i:s', strtotime($item->created_at)) }} WIB
                                                </small>
                                            </td>
                                            <td style="text-transform:uppercase">{{ $item->payment_type }}</td>
                                            @if ($item->noresi == '0')
                                                <td>Belum Ada</td>
                                            @else
                                                <td>{{ $item->noresi }}</td>
                                            @endif
                                            <td>Rp. {{ number_format($item->total_price) }}</td>
                                            @if ($item->status == '0')
                                                <td><span class="badge bg-danger text-white">Menunggu Konfirmasi</span></td>
                                            @elseif($item->status == '1')
                                                <td><span class="badge bg-warning text-dark">Menunggu Pembayaran</span></td>
                                            @elseif($item->status == '2')
                                                <td><span class="badge bg-primary text-white">Telah Dibayar</span></td>
                                            @elseif ($item->status == '3')
                                                <td><span class="badge bg-info text-white">Sedang dikirm</span></td>
                                            @elseif ($item->status == '4')
                                                <td><span class="badge bg-success text-white">Selesai</span></td>
                                            @else
                                                <td class="col-md-2">
                                                    <span class="badge bg-danger text-white">Dibatalkan</span>
                                                    @if ($item->midtrans_status == 'deny' || $item->midtrans_status == 'cancel')
                                                        <p class="text-muted fw-lighter">(Pembayaran Gagal)</p>
                                                    @elseif ($item->midtrans_status == 'expire')
                                                        <p class="text-muted fw-lighter">(Pembayaran melebihi batas waktu)
                                                        </p>
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                <a href="{{ url('admin/view-order-details/' . $item->id) }}"
                                                    class="btn btn-info">Lihat</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td class="text-center" colspan="6">
                                        <h4>Tidak Ada Pesanan di Bulan yang dipilih</h4>
                                    </td>
                                @endif
                            </tbody>
                        </table>
                        <div class="pagination mt-5 justify-content-center">
                            <div class="d-flex">
                                {!! $orders->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('select[name="month"]').on('change', function() {
            let month = $(this).val();

            if (month == '') {
                $("button[name='btn_month_print']").prop('disabled', true);
                $('select[name="month_print"]').val(month);
            } else {
                $("button[name='btn_month_print']").prop('disabled', false);
                $('select[name="month_print"]').val(month);
            }
        });

        $('select[name="month_print"]').on('change', function() {
            let month = $(this).val();

            if (month == '') {
                $("button[name='btn_month_print']").prop('disabled', true);
                $('select[name="month"]').val(month);
            } else {
                $("button[name='btn_month_print']").prop('disabled', false);
                $('select[name="month"]').val(month);
            }
        });
    </script>
@endsection
