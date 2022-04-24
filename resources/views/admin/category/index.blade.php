@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
    <div class="card card-nav-tabs">
        <div class="card-header card-header-info">
            <h3 class="text-center">Daftar Kategori</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th><strong>ID</strong></th>
                        <th><strong>Nama</strong></th>
                        <th><strong>Deskripsi</strong></th>
                        <th><strong>Slug</strong></th>
                        <th><strong>Gambar</strong></th>
                        <th><strong>Aksi</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category as $item)
                        <tr class="text-center">
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>
                                <img src="{{ asset('assets/uploads/category/' . $item->image) }}" class="cate-img"
                                    alt="Gambar Kategori">
                            </td>
                            <td>
                                <a href="{{ url('edit-category/' . $item->id) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ url('delete-category/' . $item->id) }}" class="btn btn-danger"
                                    onclick="return confirm('Yakin Menghapus Kategori ini?');">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
