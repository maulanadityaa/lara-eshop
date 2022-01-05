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
                        <th><strong>Deskripsi</strong></th>
                        <th><strong>Slug</strong></th>
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
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>{{ $item->size }}</td>
                            <td>
                                <img src="{{ asset('assets/uploads/product/'.$item->image) }}" class="cate-img" alt="Gambar Kategori">
                            </td>
                            <td>
                                <a href="{{ url('edit-category/'.$item->id) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ url('delete-category/'.$item->id) }}" class="btn btn-danger" onclick="return confirm('Yakin Menghapus Kategori ini?');">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection