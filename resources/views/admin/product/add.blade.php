@extends('layouts.admin')

@section('content')
    <div class="card card-nav-tabs">
        <div class="card-header card-header-primary">
            <h3 class="text-center">Tambah Produk</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('insert-products') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <select class="form-select" name="cate_id">
                            <option selected>---Pilih Kategori---</option>
                            @foreach ($category as $item)
                                @if (old('cate_id') == $item->id)
                                    <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="slug"
                            placeholder="Slug akan Terisi Otomatis" value="{{ old('slug') }}" readonly>
                        @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Deskripsi</label>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input id="description" type="hidden" name="description" value="{{ old('description') }}"
                        >
                        <trix-editor input="description"></trix-editor>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Harga Asli</label>
                        <input type="number" class="form-control @error('original_price') is-invalid @enderror"
                            name="original_price" value="{{ old('original_price') }}">
                        @error('original_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Harga Jual</label>
                        <input type="number" class="form-control @error('sell_price') is-invalid @enderror"
                            name="sell_price" value="{{ old('sell_price') }}">
                        @error('sell_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Stock</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock"
                            value="{{ old('stock') }}">
                        @error('stock')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Ukuran</label>
                        <input type="text" class="form-control @error('size') is-invalid @enderror" name="size"
                            value="{{ old('size') }}">
                        @error('size')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                            value="{{ old('image') }}">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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
