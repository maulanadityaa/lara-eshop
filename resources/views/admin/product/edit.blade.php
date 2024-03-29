@extends('layouts.admin')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <br>
    <div class="card card-nav-tabs">
        <div class="card-header card-header-primary">
            <h3 class="text-center">Tambah Produk</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('update-product/' . $products->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <select class="form-select">
                            <option selected>{{ $products->category->name }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" value="{{ $products->name }}" name="name" id="name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Slug</label>
                        <input type="text" class="form-control" value="{{ $products->slug }}" name="slug" id="slug"
                            placeholder="Slug akan Terisi Otomatis" readonly>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Deskripsi</label>
                        <input id="description" type="hidden" name="description" value="{{ $products->description }}"
                        >
                        <trix-editor input="description"></trix-editor>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Harga Asli</label>
                        <input type="number" class="form-control" value="{{ $products->original_price }}"
                            name="original_price">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Harga Jual</label>
                        <input type="number" class="form-control" value="{{ $products->sell_price }}" name="sell_price"
                        >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Stock</label>
                        <input type="number" class="form-control" value="{{ $products->stock }}" name="stock">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Ukuran</label>
                        <input type="text" class="form-control" value="{{ $products->size }}" name="size">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Status</label>
                        <input type="checkbox" {{ $products->status ? 'checked' : '' }} name="status">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Populer</label>
                        <input type="checkbox" {{ $products->trending ? 'checked' : '' }} name="trending">
                    </div>
                    @if ($products->image)
                        <img src="{{ asset('assets/uploads/product/' . $products->image) }}" class="img-thumbnail"
                            width="300" height="300" alt="Gambar Produk">
                    @endif
                    <div class="col-md-12">
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Edit Produk</button>
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

        name.addEventListener('change', function() {
            fetch('/products/check-slug?name=' + name.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });

        document.addEventListener('trix-file-accept', function(e) {
            e.prevenDefault();
        });
    </script>
@endsection
