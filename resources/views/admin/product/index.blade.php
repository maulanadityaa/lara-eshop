@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="text-center"><strong>Daftar Produk</strong></h3>
            <hr>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th><strong>ID</strong></th>
                        <th><strong>Nama</strong></th>
                        <th><strong>Kategori</strong></th>
                        <th><strong>Harga Asli</strong></th>
                        <th><strong>Harga Jual</strong></th>
                        <th><strong>Ukuran</strong></th>
                        <th><strong>Gambar</strong></th>
                        <th><strong>Aksi</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                        <tr class="text-center">
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>Rp. {{ number_format($item->original_price) }}</td>
                            <td>Rp. {{ number_format($item->sell_price) }}</td>
                            <td>{{ $item->size }}</td>
                            <td>
                                <img src="{{ asset('assets/uploads/product/'.$item->image) }}" class="cate-img" alt="Gambar Kategori">
                            </td>
                            <td>
                                <a href="{{ url('edit-product/'.$item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ url('delete-product/'.$item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Menghapus Produk ini?');">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection