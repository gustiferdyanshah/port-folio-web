@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Produk</h2>

    <form action="{{ route('admin.produk.update', $produk->id) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        {{-- route kita pakai POST, jadi JANGAN pakai PUT --}}

        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text"
                   name="nama"
                   class="form-control"
                   value="{{ $produk->nama }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi"
                      rows="3"
                      class="form-control"
                      required>{{ $produk->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number"
                   name="harga"
                   class="form-control"
                   value="{{ $produk->harga }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number"
                   name="stok"
                   class="form-control"
                   min="0"
                   value="{{ $produk->stok }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Produk</label><br>

            @if($produk->image)
                <img src="{{ asset($produk->image) }}"
                     alt="{{ $produk->nama }}"
                     class="img-thumbnail mb-2"
                     style="width:150px">
            @else
                <p class="text-muted">Tidak ada gambar</p>
            @endif

            <input type="file"
                   name="image"
                   class="form-control">

            <small class="text-muted">
                Kosongkan jika tidak ingin mengganti gambar
            </small>
        </div>

        <button type="submit" class="btn btn-success">
            Update
        </button>

        <a href="{{ route('admin.produk.index') }}"
           class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>
@endsection
