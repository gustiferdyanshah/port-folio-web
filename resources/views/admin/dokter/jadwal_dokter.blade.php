@extends('layouts.admin')

@section('title','Jadwal Dokter')

@section('content')
<h4 class="mb-4">🗓️ Jadwal Dokter</h4>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm mb-4">
<div class="card-body">

<form method="POST" action="{{ route('admin.dokter.jadwal.store') }}">
@csrf

<div class="row">
    <div class="col-md-3">
        <label>Dokter</label>
        <select name="doctors_id" class="form-control" required>
            <option value="">-- Pilih Dokter --</option>
            @foreach($doctors as $dokter)
                <option value="{{ $dokter->id }}">{{ $dokter->nama_dokter }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>

    <div class="col-md-2">
        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" class="form-control" required>
    </div>

    <div class="col-md-2">
        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" class="form-control" required>
    </div>

    <div class="col-md-2">
        <label>Kuota</label>
        <input type="number" name="kuota" class="form-control" min="1" required>
    </div>

    <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-success w-100">Tambah</button>
    </div>
</div>

</form>

</div>
</div>

<div class="card shadow-sm">
<div class="card-body table-responsive">

<table class="table table-bordered">
<thead class="table-success text-center">
<tr>
    <th>No</th>
    <th>Dokter</th>
    <th>Tanggal</th>
    <th>Jam</th>
    <th>Kuota</th>
</tr>
</thead>
<tbody>
@forelse($jadwals as $item)
<tr>
    <td class="text-center">
        {{ $loop->iteration + ($jadwals->currentPage()-1) * $jadwals->perPage() }}
    </td>
    <td>{{ $item->nama_dokter }}</td>
    <td class="text-center">
        {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
    </td>
    <td class="text-center">
        {{ $item->jam_mulai }} - {{ $item->jam_selesai }}
    </td>
    <td class="text-center">{{ $item->kuota }}</td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-muted">
        Belum ada jadwal dokter
    </td>
</tr>
@endforelse
</tbody>
</table>

{{-- PAGINATION --}}
@if($jadwals->hasPages())
<div class="d-flex justify-content-center mt-3">
    {{ $jadwals->links() }}
</div>
@endif

</div>
</div>
@endsection