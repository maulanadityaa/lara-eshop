@extends('layouts.front')

@section('title')
    Pesanan Saya
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-light text-dark">
        <div class="container">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > <a href="{{ url('/my-orders') }}">Pesanan Saya</a> > {{ $orders->id }}</h5>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3 class="text-center text-dark"><strong>Detail Pesanan</strong></h3>
                        <h4 class="text-center text-dark" name="invId">{{ $orders->id }}</h4>
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
                                <label for="">Jasa Ekspedisi</label>
                                <div class="border">{{ $orders->courier }}</div>
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
                                <h5 class="px-2">Ongkir<span class="float-end">Rp.
                                        {{ number_format($orders->ongkir) }}</span></h5>
                                <hr>
                                <h4 class="px-2">Total Harga<span class="float-end"><strong>Rp.
                                            {{ number_format($orders->total_price) }}</strong></span></h4><br>
                                {{-- @php
                                    dd($orders->snaptoken);
                                @endphp --}}
                                <div class="float-end">
                                    <button type="button" class="btn btn-success" type="submit" name="bayar"><i class="far fa-credit-card"></i>  Bayar Sekarang</button>
                                </div>
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
        $('button[name="bayar"]').on('click', function() {
            var id = $("h4[name=invId]").html()

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            if (id) {
                $.ajax({
                    url: "/checkout/place-order/paynow/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        // $("button[name=midtrans]").prop('disabled', false)
                        // $("button[name=bayar]").prop('disabled', true)
                        // swal("Pembuatan Pesanan Berhasil!", "Silahkan Lanjutkan Pembayaran", "success")
                        //     .then(function() {
                        //         location.reload();
                        //     });;
                        // window.location.reload();
                        snap.pay(response, {
                            // Optional
                            onSuccess: function(result) {
                                /* You may add your own js here, this is just example */
                                document.getElementById('result-json').innerHTML += JSON
                                    .stringify(result, null, 2);
                            },
                            // Optional
                            onPending: function(result) {
                                /* You may add your own js here, this is just example */
                                document.getElementById('result-json').innerHTML += JSON
                                    .stringify(result, null, 2);
                            },
                            // Optional
                            onError: function(result) {
                                /* You may add your own js here, this is just example */
                                document.getElementById('result-json').innerHTML += JSON
                                    .stringify(result, null, 2);
                            }
                        });
                    }
                });
            }
        });

        document.getElementById('payNow').onclick = function() {
            var snapToken = '<?php echo $orders->snaptoken; ?>';
            // console.log('hahahah');
            // console.log(snapToken);

            snap.pay(snapToken, {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        }
    </script>
@endsection
