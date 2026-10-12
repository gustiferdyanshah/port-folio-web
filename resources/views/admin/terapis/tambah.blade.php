@extends('layouts.admin')
@section('title', 'Tambah Terapis')

@section('content')
<div class="card shadow">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0">Tambah Terapis Baru</h4>
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

        <form method="POST" action="/admin/terapis/tambah">
            @csrf

            <div class="mb-3">
                <label for="nama_terapis" class="form-label">Nama Terapis</label>
                <input type="text" name="nama_terapis" id="nama_terapis" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="P">Perempuan</option>
                    <option value="L">Laki-laki</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="no_wa" class="form-label">No. WhatsApp</label>
                <input type="text" name="no_wa" id="no_wa" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="/admin/terapis" class="btn btn-secondary ms-2">&larr; Kembali</a>
        </form>

    </div>
</div>
@endsection
