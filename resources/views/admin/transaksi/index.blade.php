@extends('layouts.admin')

@section('title','Daftar Transaksi')

@section('content')
<h4 class="mb-4">📋 Daftar Transaksi Pasien</h4>

<div class="card shadow-sm">
<div class="card-body">

<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark text-center">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pasien</th>
            <th>Metode Pembayaran</th>
            <th>Promo</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($transaksis as $trx)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">
                {{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d-m-Y H:i') }}
            </td>
            <td>{{ $trx->nama_lengkap }}</td>
            <td class="text-center text-capitalize">
                {{ $trx->metode_pembayaran }}
            </td>
            <td class="text-center">
                {{ $trx->nama_promo ?? '-' }}
            </td>
            <td class="text-end">
                Rp {{ number_format($trx->total) }}
            </td>
            <td class="text-center">
                <a href="{{ route('admin.transaksi.show', $trx->id) }}"
                class="btn btn-sm btn-info">
                Detail
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted">
                Belum ada transaksi
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

</div>
</div>
@endsection
