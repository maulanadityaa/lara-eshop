@extends('layouts.front')

@section('title')
    Edit Profil User
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-light text-dark">
        <div class="container">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > <a
                    href="{{ url('/user-profile') }}">Profil</a> > Edit Profil</h5>
        </div>
    </div>
    <div class="container-fluid">
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col">
                <div class="card">
                    <h3 class="card-header text-center text-white" style="background: rgb(0, 0, 0)">
                        Profil User
                    </h3>
                    <div class="card-body">
                        <form action="{{ url('user-profile/edit-profile/update') }}" method="post">
                            @csrf
                            <div class="row checkout-form">
                                <div class="col-md-6">
                                    <label for="">Nama Depan</label>
                                    <input type="text" class="form-control" value="{{ $users->name }}" name="fname"
                                        placeholder="Masukkan Nama Depan">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Nama Belakang</label>
                                    <input type="text" class="form-control" value="{{ $users->lname }}" name="lname"
                                        placeholder="Masukkan Nama Belakang">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" value="{{ $users->email }}" name="email"
                                        placeholder="Masukkan Email">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Nomor HP</label>
                                    <input type="text" class="form-control" value="{{ $users->nohp }}" name="nohp"
                                        placeholder="Masukkan Nama Belakang">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Alamat Lengkap</label>
                                    <input type="text" class="form-control" value="{{ $users->alamat }}" name="address"
                                        placeholder="Masukkan Alamat Lengkap">
                                </div>
                                <div class="form-group col-md-6 mt-3">
                                    <label class="font-weight-bold">Provinsi</label>
                                    <select class="form-control form-select provinsi-tujuan" name="province_destination">
                                        <option value="0">-- pilih provinsi --</option>
                                        @foreach ($provinces as $province => $value)
                                            <option value="{{ $province }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 mt-3">
                                    <label class="font-weight-bold">Kota/Kabupaten</label>
                                    <select class="form-control form-select kota-tujuan" name="city_destination">
                                        <option value="0">-- pilih kota --</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Kode Pos</label>
                                    <input type="number" class="form-control" value="{{ $users->kodepos }}"
                                        name="postal_code" placeholder="Masukkan Kode Pos">
                                </div>
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto mt-3">
                                <button class="btn btn-success" type="submit">Update Profil</button>
                            </div>
                        </form>
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
    </script>
@endsection
