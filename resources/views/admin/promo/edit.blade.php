@extends('layouts.admin')

@section('title', 'Edit Promo')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Promo</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.promos.update', $promo->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nama Promo --}}
        <div class="mb-3">
            <label class="form-label">Nama Promo</label>
            <input type="text"
                   name="nama_promo"
                   class="form-control"
                   value="{{ old('nama_promo', $promo->nama_promo) }}"
                   required>
        </div>

        {{-- Kode Promo --}}
        <div class="mb-3">
            <label class="form-label">Kode Promo</label>
            <input type="text"
                   name="kode_promo"
                   class="form-control"
                   value="{{ old('kode_promo', $promo->kode_promo) }}">
        </div>

        {{-- Tipe Promo --}}
        <div class="mb-3">
            <label class="form-label">Tipe Promo</label>
            <select name="tipe_promo" class="form-select" required>
                <option value="diskon" {{ $promo->tipe_promo=='diskon'?'selected':'' }}>
                    Diskon
                </option>
                <option value="bundling" {{ $promo->tipe_promo=='bundling'?'selected':'' }}>
                    Bundling
                </option>
            </select>
        </div>

        {{-- Diskon --}}
        <div class="mb-3">
            <label class="form-label">Diskon (%)</label>
            <input type="number"
                   name="diskon_persen"
                   class="form-control"
                   value="{{ old('diskon_persen', $promo->diskon_persen) }}">
        </div>

        {{-- Tanggal --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date"
                       name="tanggal_mulai"
                       class="form-control"
                       value="{{ old('tanggal_mulai', $promo->tanggal_mulai) }}"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date"
                       name="tanggal_selesai"
                       class="form-control"
                       value="{{ old('tanggal_selesai', $promo->tanggal_selesai) }}"
                       required>
            </div>
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi"
                      class="form-control"
                      rows="3">{{ old('deskripsi', $promo->deskripsi) }}</textarea>
        </div>

        {{-- Gambar --}}
        <div class="mb-3">
            <label class="form-label">Gambar Promo</label><br>

            @if($promo->gambar)
                <img src="{{ asset($promo->gambar) }}"
                     class="img-thumbnail mb-2"
                     style="width:150px">
            @endif

            <input type="file"
                   name="gambar"
                   class="form-control"
                   accept="image/*">
        </div>

        <hr>

        {{-- PRODUK --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Produk yang Kena Promo</label>

            @foreach($products as $product)
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="products[]"
                           value="{{ $product->id }}"
                           {{ in_array(
                                $product->id,
                                old('products', $promo->products->pluck('id')->toArray())
                           ) ? 'checked' : '' }}>
                    <label class="form-check-label">
                        {{ $product->nama }}
                    </label>
                </div>
            @endforeach
        </div>

        <hr>

        {{-- TREATMENT --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Treatment yang Kena Promo</label>

            @foreach($treatments as $treatment)
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="treatments[]"
                           value="{{ $treatment->id }}"
                           {{ in_array(
                                $treatment->id,
                                old('treatments', $promo->treatments->pluck('id')->toArray())
                           ) ? 'checked' : '' }}>
                    <label class="form-check-label">
                        {{ $treatment->nama_treatment }}
                    </label>
                </div>
            @endforeach
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>
@endsection
