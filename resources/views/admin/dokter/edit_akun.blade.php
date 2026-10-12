@extends('layouts.admin')

@section('title','Edit Akun Dokter')

@section('content')
<h4 class="mb-4">✏️ Edit Akun Dokter</h4>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.dokter.akun.update', $doctor->id) }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Email Dokter</label>
        <input type="email"
               name="email"
               class="form-control"
               value="{{ old('email', $doctor->email) }}"
               required>
    </div>

    <hr>

    <div class="mb-3">
        <label class="form-label">Password Baru</label>
        <input type="password" name="password" class="form-control">
        <small class="text-muted">
            Kosongkan jika tidak ingin mengganti password
        </small>
    </div>

    <div class="mb-4">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>

    <button class="btn btn-primary">💾 Simpan</button>
    <a href="/admin/dokter" class="btn btn-secondary">Kembali</a>
</form>
@endsection
