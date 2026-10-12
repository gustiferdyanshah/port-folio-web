@extends('layouts.dokter')

@section('title', 'Dashboard Dokter')

@section('content')
<form action="{{ route('dokter.dashboard') }}" method="GET" class="mb-4">
    <div class="input-group">
        <input
            type="text"
            name="keyword"
            class="form-control"
            placeholder="Cari pasien (nama / email / WA)..."
            value="{{ $keyword }}"
        >
        <button class="btn btn-primary">Cari</button>
    </div>
</form>

@if(!empty($keyword))
    @if($pasien)
        <div class="card mb-4">
            <div class="card-body">
                <h6> Hasil Pencarian Pasien</h6>
                <p><strong>Nama:</strong> {{ $pasien->nama_lengkap }}</p>
                <p><strong>Email:</strong> {{ $pasien->email }}</p>
                <p><strong>No. WA:</strong> {{ $pasien->no_wa ?? '-' }}</p>
            </div>
        </div>
    @else
        <div class="alert alert-warning mb-4">
            Pasien tidak ditemukan.
        </div>
    @endif
@endif
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <strong>🩺 Konsultasi Belum Selesai</strong>
    </div>

    <div class="card-body p-0">
        @if($konsultasi->count() > 0)
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Konsultasi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($konsultasi as $item)
                        <tr>
                            <td>
                                {{ $loop->iteration + ($konsultasi->currentPage()-1)*$konsultasi->perPage() }}
                            </td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_konsultasi)->format('d M Y') }}
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-3">
                {{ $konsultasi->withQueryString()->links() }}
            </div>
        @else
            <div class="p-3 text-center text-muted">
                Tidak ada konsultasi yang belum selesai.
            </div>
        @endif
    </div>
</div>

@endsection
