@extends('layouts.front')

@section('title')
    Profil User
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-light text-dark">
        <div class="container">
            <h5 class="mb-0"><a href="{{ url('/') }}">Home</a> > Profil User</h5>
        </div>
    </div>
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container">
            <div class="col">
                <div class="card">
                    <h3 class="card-header text-center text-white" style="background: rgb(0, 0, 0)">
                        Profil User
                    </h3>
                    <div class="card-body">
                        <form action="{{ url('user-profile/edit-profile') }}" method="get">
                            @csrf
                            <div class="row checkout-form">
                                <div class="col-md-6">
                                    <label for="">Nama Depan</label>
                                    <div type="text" class="form-control">{{ $users->name }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Nama Belakang</label>
                                    @if ($users->lname)
                                        <div type="text" class="form-control">{{ $users->lname }}</div>
                                    @else
                                        <div type="text" class="form-control">Belum Ada</div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Email</label>
                                    <div type="text" class="form-control">{{ $users->email }}</div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Nomor HP</label>
                                    @if ($users->nohp)
                                        <div type="text" class="form-control">{{ $users->nohp }}</div>
                                    @else
                                        <div type="text" class="form-control">Belum Ada</div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Alamat Lengkap</label>
                                    @if ($users->alamat)
                                        <div type="text" class="form-control">{{ $users->alamat }}</div>
                                    @else
                                        <div type="text" class="form-control">Belum Ada</div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Kota</label>
                                    @if ($city)
                                        <div type="text" class="form-control">{{ $city->name }}</div>
                                    @else
                                        <div type="text" class="form-control">Belum Ada</div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Provinsi</label>
                                    @if ($province)
                                        <div type="text" class="form-control">{{ $province->name }}</div>
                                    @else
                                        <div type="text" class="form-control">Belum Ada</div>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Kode Pos</label>
                                    @if ($users->kodepos)
                                        <div type="text" class="form-control">{{ $users->kodepos }}</div>
                                    @else
                                        <div type="text" class="form-control">Belum Ada</div>
                                    @endif
                                </div>
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto mt-3">
                                <button class="btn btn-primary" type="submit">Edit Profil</button>
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
