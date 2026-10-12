@extends('layouts.admin')
@section('title', 'Daftar Reward')

@section('content')
<h2 class="mb-4">Daftar Reward</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="/admin/reward/tambah" class="btn btn-primary mb-3">+ Tambah Reward</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>Nama Item</th>
                <th>Deskripsi</th>
                <th>Stok</th>
                <th>Poin Dibutuhkan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->nama_items }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->poin_yang_dibutuhkan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
