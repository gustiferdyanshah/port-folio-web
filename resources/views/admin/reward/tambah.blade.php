@extends('layouts.admin')
@section('title', 'Tambah Reward')

@section('content')
<h2 class="mb-4">Tambah Reward Item</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form method="POST" action="/admin/reward/tambah">
    @csrf
    <div class="mb-3">
        <label>Nama Item</label>
        <input type="text" name="nama_items" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <input type="text" name="deskripsi" class="form-control">
    </div>
    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stok" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Poin yang Dibutuhkan</label>
        <input type="number" name="poin_yang_dibutuhkan" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="/admin/reward" class="btn btn-secondary">Kembali</a>
</form>
@endsection
