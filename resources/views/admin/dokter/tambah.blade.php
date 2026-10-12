@extends('layouts.admin')
@section('title', 'Tambah Dokter')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Tambah Dokter Baru</h4>
    </div>
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/admin/dokter/tambah">
            @csrf
            <div class="mb-3">
                <label for="nama_dokter" class="form-label">Nama Dokter</label>
                <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/admin/dokter" class="btn btn-secondary ms-2">&larr; Kembali</a>
        </form>

    </div>
</div>
@endsection
