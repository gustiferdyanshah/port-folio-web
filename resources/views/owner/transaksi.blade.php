@extends('layouts.owner')

@section('title', 'Laporan Transaksi')

@section('content')
<h4 class="mb-3">📋 Laporan Transaksi</h4>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal Transaksi</th>
            <th>Total</th>
            <th>Customer</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($transaksi as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y H:i') }}</td>
                <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                <td>{{ $t->customer_id ?? '-' }}</td>
                <td>{{ $t->status ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Data transaksi kosong</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
