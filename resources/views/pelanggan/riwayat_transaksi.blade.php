@extends('layouts.pelanggan')
@section('title', 'Riwayat Transaksi')

@section('content')
<h4 class="mb-4">Riwayat Transaksi Anda</h4>

<form method="GET" class="row g-3 mb-3">
    <div class="col-md-3">
        <label>Dari Tanggal</label>
        <input type="date" name="from" value="{{ request('from') }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label>Sampai Tanggal</label>
        <input type="date" name="to" value="{{ request('to') }}" class="form-control">
    </div>
    <div class="col-md-3 d-flex align-items-end gap-2">
        <button class="btn btn-success">Terapkan</button>
        <a href="{{ route('pelanggan.riwayat-transaksi') }}" class="btn btn-secondary">Reset</a>
    </div>
</form>

@if($transaksi->isEmpty())
    <div class="alert alert-warning">
        Tidak ada riwayat transaksi
    </div>
@else
<div class="table-responsive">
<table class="table table-bordered table-striped align-middle">
    <thead class="table-success text-center">
        <tr>
            <th>#</th>
            <th>Tanggal Transaksi</th>
            <th>Nama Treatment</th>
            <th>Nama Produk</th>
            <th>Nama Terapis</th>
            <th>Tanggal Booking</th>
            <th>Metode Pembayaran</th>
            <th>Subtotal</th>
            <th>Total Transaksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $i => $row)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>

            <td>{{ \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d/m/Y H:i') }}</td>

            <td>
                @if(!empty($row->nama_treatment))
                    @foreach(explode(', ', $row->nama_treatment) as $t)
                        <div>{{ $t }}</div>
                    @endforeach
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            <td>
                @if(!empty($row->nama_produk))
                    @foreach(explode(', ', $row->nama_produk) as $p)
                        <div>{{ $p }}</div>
                    @endforeach
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            <td>
                @if(!empty($row->nama_terapis))
                    @foreach(explode(', ', $row->nama_terapis) as $t)
                        <div>{{ $t }}</div>
                    @endforeach
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            <td>
                @if(!empty($row->tanggal_booking))
                    @foreach(explode(', ', $row->tanggal_booking) as $tgl)
                        <div>{{ \Carbon\Carbon::parse($tgl)->format('d/m/Y') }}</div>
                    @endforeach
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            <td class="text-center">{{ ucfirst($row->metode_pembayaran) }}</td>

            <td class="text-end">
                Rp {{ number_format($row->subtotal, 0, ',', '.') }}
            </td>

            <td class="text-end fw-semibold">
                Rp {{ number_format($row->total, 0, ',', '.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endif
@endsection
