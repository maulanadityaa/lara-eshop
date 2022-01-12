@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h3><strong>Tambah Produk</strong></h3>
            <hr>
        </div>
        <div class="card-body">
            <form action="{{ url('insert-products') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <select class="form-select" name="cate_id">
                            <option selected>---Pilih Kategori---</option>
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Slug</label>
                        <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug akan Terisi Otomatis" readonly>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Deskripsi</label>
                        <textarea name="description" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Harga Asli</label>
                        <input type="number" class="form-control" name="original_price">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Harga Jual</label>
                        <input type="number" class="form-control" name="sell_price">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Stock</label>
                        <input type="number" class="form-control" name="stock">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Ukuran</label>
                        <input type="text" class="form-control" name="size">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Status</label>
                        <input type="checkbox" name="status">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Populer</label>
                        <input type="checkbox" name="trending">
                    </div>
                    <div class="col-md-12">
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Tambah Produk</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const name = document.querySelector('#name');
        const slug = document.querySelector('#slug');

        name.addEventListener('change', function(){
            fetch('/products/check-slug?name=' + name.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
        });
    </script>
@endsection
