@extends('layouts.admin')
@section('title', 'Edit Treatment')

@section('content')
<div class="container">
    <h4 class="mb-4">Form Edit Treatment</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.treatment.update', $treatment->id) }}"
            method="POST"
            enctype="multipart/form-data">
         @csrf
         @method('PUT')
    

        <!-- Nama -->
        <div class="mb-3">
            <label class="form-label">Nama Treatment</label>
            <input type="text"
                   name="nama_treatment"
                   class="form-control"
                   value="{{ $treatment->nama_treatment }}"
                   required>
        </div>

        <!-- Tipe -->
        <div class="mb-3">
            <label class="form-label">Tipe Treatment</label>
            <select name="treatment_types_id"
                    class="form-select"
                    required>
                <option value="">-- Pilih Tipe --</option>
                @foreach($treatmentTypes as $type)
                    <option value="{{ $type->id }}"
                        {{ $treatment->treatment_types_id == $type->id ? 'selected' : '' }}>
                        {{ $type->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Harga -->
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number"
                   name="harga"
                   class="form-control"
                   value="{{ $treatment->harga }}"
                   required>
        </div>

        <!-- Durasi -->
        <div class="mb-3">
            <label class="form-label">Durasi (menit)</label>
            <input type="number"
                   name="durasi"
                   class="form-control"
                   value="{{ $treatment->durasi }}"
                   required>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi"
                      rows="4"
                      class="form-control">{{ $treatment->deskripsi }}</textarea>
        </div>

        <!-- Gambar -->
        <div class="mb-3">
            <label class="form-label">Gambar Treatment</label><br>

            @if($treatment->gambar)
                <img src="{{ asset($treatment->gambar) }}"
                     class="img-thumbnail mb-2"
                     style="width:150px">
            @else
                <p class="text-muted">Tidak ada gambar</p>
            @endif

            <input type="file"
                   name="gambar"
                   class="form-control"
                   accept="image/*">

            <small class="text-muted">
                Kosongkan jika tidak ingin mengganti gambar
            </small>
        </div>

        <!-- Tombol -->
        <button type="submit" class="btn btn-primary">
            Perbarui
        </button>

        <a href="{{ route('admin.treatment.index') }}"
           class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>
@endsection
