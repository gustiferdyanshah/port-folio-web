@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-success">Tambah Produk</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.produk.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <!-- Nama -->
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="{{ old('nama') }}"
                           required>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi"
                              class="form-control"
                              rows="4"
                              required>{{ old('deskripsi') }}</textarea>
                </div>

                <!-- Harga -->
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number"
                           name="harga"
                           class="form-control"
                           value="{{ old('harga') }}"
                           required>
                </div>

                <!-- Stok -->
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number"
                           name="stok"
                           class="form-control"
                           min="0"
                           value="{{ old('stok', 0) }}"
                           required>
                </div>

                <!-- Gambar -->
                <div class="mb-3">
                    <label class="form-label">Gambar Produk</label>
                    <input type="file"
                           name="image"
                           class="form-control"
                           accept="image/*">
                    <small class="text-muted">
                        Opsional. Format jpg / jpeg / png
                    </small>
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.produk.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-success">
                        Simpan Produk
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
