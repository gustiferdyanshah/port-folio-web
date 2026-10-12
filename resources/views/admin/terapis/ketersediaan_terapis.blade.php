@extends('layouts.admin')
@section('title','Ketersediaan Terapis')

@section('content')
<h4 class="mb-4">🧑‍⚕️ Ketersediaan Terapis</h4>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="date" name="tanggal"
               value="{{ request('tanggal', $tanggal) }}"
               class="form-control">
    </div>

    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">-- Semua Status --</option>
            <option value="tersedia" {{ request('status')=='tersedia'?'selected':'' }}>
                Tersedia
            </option>
            <option value="melayani" {{ request('status')=='melayani'?'selected':'' }}>
                Tugas
            </option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-success w-100">Filter</button>
    </div>
</form>

<div class="card shadow-sm">
<div class="card-body table-responsive">

<table class="table table-bordered align-middle">
    <thead class="table-success text-center">
        <tr>
            <th>No</th>
            <th>Terapis</th>
            <th>Status</th>
            <th>Pasien</th>
            <th>Treatment</th>
            <th>Tanggal</th>
            <th>Jam</th>
        </tr>
    </thead>
    <tbody>
    @forelse($data as $item)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $item->nama_terapis }}</td>
            <td class="text-center">
                <span class="badge bg-{{ $item->status=='tersedia' ? 'success' : 'warning' }}">
                    {{ ucfirst($item->status) }}
                </span>
            </td>
            <td>{{ $item->pasien ?? '-' }}</td>
            <td>{{ $item->nama_treatment ?? '-' }}</td>
            <td class="text-center">
                {{ $item->tanggal_booking
                    ? \Carbon\Carbon::parse($item->tanggal_booking)->format('d-m-Y')
                    : '-' }}
            </td>
            <td class="text-center">
                @if($item->jam_booking)
                    {{ $item->jam_booking }} - {{ $item->jam_ending }}
                @else
                    -
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted">
                Tidak ada data
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

</div>
</div>
@endsection
