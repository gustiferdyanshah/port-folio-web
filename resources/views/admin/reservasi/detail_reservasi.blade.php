@extends('layouts.admin')
@section('title', 'Detail Reservasi')

@section('content')
<h2 class="mb-4">Detail Reservasi #{{ $appointment->id }}</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="mb-3">
    <label class="form-label">Customer</label>
    <input type="text" class="form-control"
           value="{{ $appointment->customer->nama_lengkap ?? '-' }}" disabled>
</div>

<div class="mb-3">
    <label class="form-label">Status Reservasi</label>
    <select name="status" class="form-select" form="form-status">
        <option value="reserv" {{ $appointment->status=='reserv' ? 'selected' : '' }}>Reserv</option>
        <option value="berjalan" {{ $appointment->status=='berjalan' ? 'selected' : '' }}>Berjalan</option>
        <option value="selesai" {{ $appointment->status=='selesai' ? 'selected' : '' }}>Selesai</option>
        <option value="batal" {{ $appointment->status=='batal' ? 'selected' : '' }}>Batal</option>
    </select>
</div>

<form id="form-status" method="POST"
      action="{{ route('admin.reservasi.update', $appointment->id) }}">
@csrf

<h4 class="mt-4">Daftar Treatment</h4>

<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr>
            <th>Treatment</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Terapis</th>
        </tr>
    </thead>
    <tbody>
        @foreach($appointment->reservasiServices as $rs)
        <tr>
            <td>
                {{ $rs->service->treatment->nama_treatment
                    ?? $rs->service->nama_service ?? '-' }}
            </td>
            <td>{{ \Carbon\Carbon::parse($rs->tanggal_booking)->format('d-m-Y') }}</td>
            <td>
                {{ $rs->jam_booking }}
                @if($rs->jam_ending) - {{ $rs->jam_ending }} @endif
            </td>
            <td>{{ $rs->terapis->nama_terapis ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mb-3">
    <label class="form-label">Hasil Konsultasi</label>
    <textarea class="form-control" rows="4" disabled>
{{ $appointment->hasil_konsultasi ?? '-' }}
    </textarea>
</div>

<button type="submit" class="btn btn-primary">Simpan Status</button>
<a href="{{ route('admin.reservasi.index') }}" class="btn btn-secondary ms-2">
    Kembali
</a>
</form>
@endsection
