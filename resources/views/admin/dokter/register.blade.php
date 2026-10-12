@extends('layouts.admin')

@section('title','Register Akun Dokter')

@section('content')

<h4 class="mb-4">➕ Register Akun Dokter</h4>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.dokter.store') }}">
@csrf

    <div class="mb-3">
        <label class="form-label">Nama Dokter</label>
        <select name="doctor_id" class="form-select" required>
            <option value="">-- Pilih Dokter --</option>
            @foreach($doctors as $dokter)
                <option value="{{ $dokter->id }}">
                    {{ $dokter->nama_dokter }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email"
               name="email"
               class="form-control"
               required>
    </div>

    {{-- PASSWORD --}}
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password"
               name="password"
               class="form-control"
               required>
    </div>

    <div class="mb-4">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password"
               name="password_confirmation"
               class="form-control"
               required>
    </div>

    <button class="btn btn-primary">Simpan Akun</button>
</form>

@endsection
