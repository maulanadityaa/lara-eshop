@extends('layouts.front')

@section('title')
    Halaman Checkout
@endsection

@section('content')
    @php
    $total_berat = 0;
    $jumlah_brg = 0;
    $total_harga = 0;
    @endphp
    @foreach ($cartitems as $item)
        @php
            $total_berat += $item->prod_qty * 1000;
            $jumlah_brg += $item->prod_qty;
            $total_harga += $item->products->sell_price * $item->prod_qty;
        @endphp
    @endforeach
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold">Detail Pengiriman</h5>
                        <hr>
                        <div class="row checkout-form">
                            <div class="col-md-6">
                                <label for="">Nama Depan</label>
                                <input type="text" class="form-control" name="" placeholder="Masukkan Nama Depan">
                            </div>
                            <div class="col-md-6">
                                <label for="">Nama Belakang</label>
                                <input type="text" class="form-control" name="" placeholder="Masukkan Nama Belakang">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Email</label>
                                <input type="text" class="form-control" name="" placeholder="Masukkan Email">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Nomor HP</label>
                                <input type="text" class="form-control" name="" placeholder="Masukkan Nama Belakang">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Alamat Lengkap</label>
                                <input type="text" class="form-control" name="" placeholder="Masukkan Alamat Lengkap">
                            </div>
                            {{-- <div class="col-md-6 mt-3">
                                    <label for="">Provinsi</label>
                                    <input type="text" class="form-control" name="" placeholder="Masukkan Nama Provinsi">
                                </div> --}}
                            <div class="form-group col-md-6 mt-3">
                                <label class="font-weight-bold">Provinsi</label>
                                <select class="form-control provinsi-tujuan" name="province_destination">
                                    <option value="0">-- pilih provinsi --</option>
                                    @foreach ($provinces as $province => $value)
                                        <option value="{{ $province }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-md-6 mt-3">
                                    <label for="">Kota/Kabupaten</label>
                                    <input type="text" class="form-control" name="" placeholder="Masukkan Nama Kota/Kabupaten">
                                </div> --}}
                            <div class="form-group col-md-6 mt-3">
                                <label class="font-weight-bold">Kota/Kabupaten</label>
                                <select class="form-control kota-tujuan" name="city_destination">
                                    <option value="0">-- pilih kota --</option>
                                    {{-- @foreach ($provinces as $province => $value)
                                            <option value="{{ $province  }}">{{ $value }}</option>
                                        @endforeach --}}
                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Kode Pos</label>
                                <input type="number" class="form-control" name="kode-pos" placeholder="Masukkan Kode Pos">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="">Total Berat (gram)</label>
                                <input type="number" class="form-control" name="total_berat" id="total_berat"
                                    value="{{ $total_berat }}" readonly>
                            </div>
                            <input type="hidden" name="total_harga" value="{{ $total_harga }}">
                            <div class="col-md-6 mt-3 mx-auto">
                                <label class="font-weight-bold">Kurir/Ekspedisi</label>
                                <select class="form-control" name="courier_name">
                                    <option value="0">-- pilih kurir --</option>
                                    <option value="jne">JNE</option>
                                    <option value="pos">POS</option>
                                    <option value="tiki">TIKI</option>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label class="font-weight-bold">Ongkos Kirim</label>
                                <select class="form-control ongkos-kirim" name="harga_ongkir">
                                    <option value="0">-- pilih ongkir --</option>
                                    {{-- @foreach ($provinces as $province => $value)
                                            <option value="{{ $province  }}">{{ $value }}</option>
                                        @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card order-data">
                    <div class="card-body">
                        <h5 class="fw-bold">Detail Order</h5>
                        <hr>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Berat</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($cartitems as $item)
                                    <tr>
                                        <td>{{ $item->products->name }}</td>
                                        <td>{{ $item->prod_qty }}</td>
                                        <td>{{ $item->prod_qty * 1000 }} gr</td>
                                        <td>Rp. {{ number_format($item->products->sell_price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total :</td>
                                    <td>{{ $jumlah_brg }}</td>
                                    <td>{{ $total_berat }} gr</td>
                                    <td id="total_harga">Rp. {{ number_format($total_harga) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        <hr>
                        <h6>Ongkos Kirim</h6>
                        {{-- <input type="number" class="form-control total_ongkir" name="total_ongkir" readonly> --}}
                        <input type="text" name="total_ongkir" value="Belum ditanbahkan" class="form-control total_ongkir" readonly/>
                        <div class="d-grid gap-2 col-6 mx-auto mt-3">
                            <button class="btn btn-primary" type="button">Buat Pesanan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('select[name="province_destination"]').on('change', function() {
            let provindeId = $(this).val();
            if (provindeId) {
                jQuery.ajax({
                    url: '/cek-ongkir/cities/' + provindeId,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('select[name="city_destination"]').empty();
                        $('select[name="city_destination"]').append(
                            '<option value="">-- pilih kota --</option>');
                        $.each(response, function(key, value) {
                            $('select[name="city_destination"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                $('select[name="city_destination"]').append('<option value="">-- pilih kota --</option>');
            }
        });

        let isProcessing = false;
        $('select[name="courier_name"]').on('change', function() {
            let courier = $(this).val();
            let token = $("meta[name='csrf-token']").attr("content");
            let city_destination = $('select[name=city_destination]').val();
            //   let courier = $('select[name=courier_name]').val();
            let weight = $('#total_berat').val();

            if (isProcessing) {
                return;
            }

            isProcessing = true;

            if (courier) {
                jQuery.ajax({
                    url: '/cek-ongkir',
                    method: "POST",
                    data: {
                        _token: token,
                        city_destination: city_destination,
                        courier: courier,
                        weight: weight
                    },
                    dataType: "json",
                    success: function(response) {
                        isProcessing = false;
                        if (response) {
                            $('#ongkir').empty();
                            $('.ongkir').addClass('d-block');
                            $.each(response[0]['costs'], function(key, value) {
                                $('#ongkir').append('<li class="list-group-item">' + response[0]
                                    .code.toUpperCase() + ' : <strong>' + value.service +
                                    '</strong> - Rp. ' + value.cost[0].value + ' (' + value
                                    .cost[0].etd + ' hari)</li>')
                            });

                            $('select[name="harga_ongkir"]').empty();
                            $('select[name="harga_ongkir"]').append(
                                '<option value="">-- pilih ongkir --</option>');
                            $.each(response[0]['costs'], function(key, value) {
                                $('select[name="harga_ongkir"]').append('<option value="' +
                                    value.cost[0].value + '">' + response[0].code
                                    .toUpperCase() + ' : ' + value.service + ' - Rp. ' +
                                    value.cost[0].value + ' (' + value.cost[0].etd +
                                    ' hari)' + '</option>');
                            });

                            // $('#total_berat').val();
                        }
                    }
                });
            } else {
                $('select[name="courier_name"]').append('<option value="">-- pilih ongkir --</option>');
            }
        });

        $('select[name="harga_ongkir"]').on('change', function() {
            let hargaOngkir = $(this).val();

            if (hargaOngkir) {
                var value = parseInt(hargaOngkir);
                value = isNaN(value) ? 0 : value;
                $('.total_ongkir').val(value);
            } else {
                $(this).closest('.order_data').find('.total_ongkir').val(0);
            }
        });
    </script>
@endsection
