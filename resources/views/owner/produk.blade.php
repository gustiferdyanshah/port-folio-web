@extends('layouts.owner')

@section('title', 'Daftar Produk')

@section('content')

<h4 class="mb-3">📦 Daftar Produk</h4>

<form method="GET" class="mb-4 d-flex gap-3 flex-wrap align-items-center">
    <label class="form-label mb-0">Filter Stok:</label>
    <select name="stok" class="form-select form-select-sm" style="width: 150px;">
        <option value="">-- Semua --</option>
        <option value="tersedia" {{ request('stok') == 'tersedia' ? 'selected' : '' }}>
            Stok Tersedia
        </option>
        <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>
            Stok Habis
        </option>
    </select>

    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
</form>

@if ($produk->isEmpty())
    <p class="text-muted">Tidak ada produk ditemukan.</p>
@else
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Sisa Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produk as $p)
                <tr @if($p->stok <= 0) class="table-danger" @endif>
                    <td>{{ $p->nama_produk }}</td>
                    <td>{{ $p->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection
