@extends('layouts.front')

@section('title')
    Pesanan Saya
@endsection

@section('content')
    <style>
        #spinner-div {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 5500;
        }

    </style>
    <div class="py-3 mb-4 shadow-sm bg-light text-dark">
        <div class="container">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > <a href="{{ url('/my-orders') }}">Pesanan
                    Saya</a> > {{ $orders->id }}</h5>
        </div>
    </div>
    <div class="container mt-3">
        <div class="d-flex align-content-center flex-wrap justify-content-center">
            <div id="spinner-div" class="pt-5">
                <div class="spinner-border text-primary" role="status">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="text-center text-white"><strong>Detail Pesanan</strong></h3>
                        <h4 class="text-center text-white" name="invId">{{ $orders->id }}</h4>
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
                                            <th><strong>Ukuran</strong></th>
                                            <th><strong>Catatan</strong></th>
                                            <th><strong>Harga</strong></th>
                                            <th><strong>Gambar</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders->orderitems as $item)
                                            <tr class="text-center">
                                                {{-- @php
                                                    dd($item);
                                                @endphp --}}
                                                <td>{{ $item->products->name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->prod_size }}</td>
                                                <td>{{ $item->message }}</td>
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
                                    @if ($orders->status == 0)
                                        <button type="button" class="btn btn-danger" type="submit" name="bayar" disabled><i
                                                class="fas fa-exclamation-triangle"></i> Menunggu Konfirmasi</button>
                                        <a class="btn btn-warning"
                                            href="{{ url('view-order/cancel-order/' . $orders->id) }}" name="cancel"><i
                                                class="fas fa-exclamation"></i>
                                            Batalkan</a>
                                    @elseif($orders->status == 1)
                                        <button type="button" class="btn btn-success" type="submit" name="bayar"><i
                                                class="far fa-credit-card"></i> Bayar Sekarang</button>
                                    @elseif($orders->status == 5)
                                        <button type="button" class="btn btn-danger" type="submit" name="bayar" disabled><i
                                                class="fas fa-exclamation-triangle"></i> Pembayaran Gagal</button>
                                    @else
                                        <button type="button" class="btn btn-info" type="submit" name="bayar" disabled><i
                                                class="far fa-check-circle"></i> Telah Dibayar</button>
                                        <a href="{{ url('view-order/print-invoice/' . $orders->id) }}" target="_blank"
                                            class="btn btn-success"><i class="fas fa-print"></i> Print
                                            Invoice</a>
                                    @endif

                                </div>
                            </div>
                            <form action="{{ url('checkout/place-order/paynow/submit-payment') }}" id="midtrans_submit"
                                method="POST">
                                @csrf
                                <input type="hidden" name="midtrans_callback">
                            </form>
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
            $('#spinner-div').show(); //Load button clicked show spinner

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
                                sendCallback(result);
                            },
                            // Optional
                            onPending: function(result) {
                                /* You may add your own js here, this is just example */
                                sendCallback(result);
                            },
                            // Optional
                            onError: function(result) {
                                /* You may add your own js here, this is just example */
                                sendCallback(result);
                            }
                        });
                    },
                    complete: function() {
                        $('#spinner-div').hide(); //Request is complete so hide spinner
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

        function sendCallback(response) {
            // document.getElementById('midtrans_callback').value = JSON.stringify(response);
            $('input[name=midtrans_callback]').val(JSON.stringify(response));
            // alert(document.getElementById('midtrans_callback').value)
            $('#midtrans_submit').submit();
        }
    </script>
@endsection
