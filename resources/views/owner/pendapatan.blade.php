@extends('layouts.owner')

@section('title', 'Laporan Pendapatan')

@section('content')

<h4 class="mb-3">📊 Laporan Pendapatan Owner</h4>

<form method="GET" class="mb-4 d-flex gap-3 flex-wrap align-items-end">
    <div>
        <label class="form-label">Tanggal Mulai</label>
        <input
            type="date"
            name="tanggal_mulai"
            class="form-control form-control-sm"
            value="{{ request('tanggal_mulai') }}"
        >
    </div>

    <div>
        <label class="form-label">Tanggal Akhir</label>
        <input
            type="date"
            name="tanggal_akhir"
            class="form-control form-control-sm"
            value="{{ request('tanggal_akhir') }}"
        >
    </div>

    <div>
        <button type="submit" class="btn btn-primary btn-sm">
            Filter
        </button>
        <a href="{{ url('/owner/pendapatan') }}" class="btn btn-secondary btn-sm">
            Reset
        </a>
    </div>
</form>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Total Pendapatan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pendapatan as $p)
            <tr>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                <td>Rp {{ number_format($p->total, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="text-center text-muted">
                    Data pendapatan kosong
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
