@extends('layouts.admin')
@section('title', 'Edit Dokter')

@section('content')
<div class="card shadow">
    <div class="card-header bg-warning">
        <h4 class="mb-0 text-dark">Edit Data Dokter</h4>
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

        <form method="POST" action="/admin/dokter/{{ $dokter->id }}/update">
            @csrf

            <div class="mb-3">
                <label for="nama_dokter" class="form-label">Nama Dokter</label>
                <input type="text" id="nama_dokter" name="nama_dokter" class="form-control" value="{{ $dokter->nama_dokter }}" required>
            </div>

            <button type="submit" class="btn btn-warning text-dark">Update</button>
            <a href="/admin/dokter" class="btn btn-secondary ms-2">&larr; Kembali</a>
        </form>

    </div>
</div>
@endsection
