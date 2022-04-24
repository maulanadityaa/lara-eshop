@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
    <div class="card card-nav-tabs">
        <div class="card-header card-header-info">
            <h3 class="text-center">Daftar Produk</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th><strong>ID</strong></th>
                        <th><strong>Nama</strong></th>
                        <th><strong>Kategori</strong></th>
                        <th><strong>Harga Asli</strong></th>
                        <th><strong>Harga Jual</strong></th>
                        <th><strong>Ukuran</strong></th>
                        <th><strong>Stock</strong></th>
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
                            <td>{{ $item->stock }}</td>
                            <td>
                                <img src="{{ asset('assets/uploads/product/' . $item->image) }}" class="cate-img"
                                    alt="Gambar Kategori">
                            </td>
                            <td>
                                <a href="{{ url('edit-product/' . $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ url('delete-product/' . $item->id) }}" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin Menghapus Produk ini?');">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
