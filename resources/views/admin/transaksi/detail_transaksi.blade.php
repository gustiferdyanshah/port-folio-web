@extends('layouts.admin')

@section('title','Detail Transaksi')

@section('content')
<h4 class="mb-4">🧾 Detail Transaksi</h4>

<div class="card shadow-sm">
<div class="card-body">

{{-- INFO TRANSAKSI --}}
<p>
    <b>Tanggal Transaksi:</b>
    {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y H:i') }}
</p>

<p>
    <b>Metode Pembayaran:</b>
    {{ strtoupper($transaksi->metode_pembayaran) }}
</p>

@if($transaksi->nama_promo)
<p>
    <b>Promo:</b> {{ $transaksi->nama_promo }}
    @if($transaksi->diskon_persen)
        ({{ $transaksi->diskon_persen }}%)
    @endif
</p>
@endif

<hr>

{{-- PRODUK --}}
<h6 class="fw-bold mb-3">🛍️ Produk</h6>
<div class="table-responsive mb-4">
<table class="table table-bordered align-middle">
<thead class="table-light">
<tr>
    <th width="60">No</th>
    <th>Nama Produk</th>
    <th width="160">Harga</th>
</tr>
</thead>
<tbody>

@forelse($produk as $item)
<tr>
    <td class="text-center">{{ $loop->iteration }}</td>
    <td>{{ $item->nama_produk ?? '-' }}</td>
    <td>Rp {{ number_format($item->harga,0,',','.') }}</td>
</tr>
@empty
<tr>
    <td colspan="3" class="text-center text-muted">
        Tidak ada produk
    </td>
</tr>
@endforelse

</tbody>
</table>
</div>

{{-- TREATMENT --}}
<h6 class="fw-bold mb-3">💆 Treatment</h6>
<div class="table-responsive">
<table class="table table-bordered align-middle">
<thead class="table-light">
<tr>
    <th width="60">No</th>
    <th>Nama Treatment</th>
    <th width="160">Harga</th>
</tr>
</thead>
<tbody>

@forelse($treatments as $item)
<tr>
    <td class="text-center">{{ $loop->iteration }}</td>
    <td>{{ $item->nama_treatment }}</td>
    <td>Rp {{ number_format($item->harga,0,',','.') }}</td>
</tr>
@empty
<tr>
    <td colspan="3" class="text-center text-muted">
        Tidak ada treatment
    </td>
</tr>
@endforelse

</tbody>
</table>
</div>

<hr>

{{-- TOTAL --}}
<div class="d-flex justify-content-end">
    <h5 class="fw-bold">
        Total: Rp {{ number_format($transaksi->total,0,',','.') }}
    </h5>
</div>

<a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary mt-3">
    ⬅ Kembali
</a>

</div>
</div>
@endsection
