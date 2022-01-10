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
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto mt-3">
                            <button type="submit" class="btn btn-success btnCekOngkir">Cek Ongkir</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
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
                        {{-- <input type="hidden" name="total_berat" value="{{ $total_berat }}">
                        <input type="hidden" name="total_harga" value="{{ $total_harga }}"> --}}
                        <hr>
                        <button class="btn btn-primary float-end">Buat Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card ongkir">
                    <div class="card-body">
                        <h5 class="fw-bold">Ongkos Pengiriman</h5>
                        <hr>
                        <ul class="list-group" id="ongkir">
                        </ul>
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
        $('.btnCekOngkir').click(function(e) {
            e.preventDefault();

            let token = $("meta[name='csrf-token']").attr("content");
            let city_destination = $('select[name=city_destination]').val();
            let courier = $('select[name=courier_name]').val();
            let weight = $('#total_berat').val();

            if (isProcessing) {
                return;
            }

            isProcessing = true;

            jQuery.ajax({
                method: "POST",
                url: "cek-ongkir",
                data: {
                    _token: token,
                    city_destination: city_destination,
                    courier: courier,
                    weight: weight
                },
                dataType: "JSON",
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

                        // $('#total_berat').val();
                    }
                }
            });
        });
    </script>
@endsection
