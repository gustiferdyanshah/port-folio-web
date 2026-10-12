@extends('layouts.admin')
@section('title', 'Edit Terapis')

@section('content')
<div class="card shadow">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">Edit Data Terapis</h4>
    </div>
    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/admin/terapis/{{ $terapis->id }}/update">
            @csrf

            <div class="mb-3">
                <label for="nama_terapis" class="form-label">Nama Terapis</label>
                <input type="text" name="nama_terapis" id="nama_terapis" class="form-control" value="{{ $terapis->nama_terapis }}" required>
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                    <option value="P" {{ $terapis->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                    <option value="L" {{ $terapis->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="no_wa" class="form-label">No. WhatsApp</label>
                <input type="text" name="no_wa" id="no_wa" class="form-control" value="{{ $terapis->no_wa }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="aktif" {{ $terapis->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $terapis->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/admin/terapis" class="btn btn-secondary ms-2">&larr; Kembali</a>
        </form>

    </div>
</div>
@endsection
