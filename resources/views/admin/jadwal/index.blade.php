@extends('layouts.admin')
@section('title', 'Daftar Jadwal Konsultasi')

@section('content')
<h4 class="mb-4">📋 Daftar Jadwal Konsultasi</h4>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="dokter" class="form-select">
            <option value="">-- Semua Dokter --</option>
            @foreach($dokters as $d)
                <option value="{{ $d->id }}" {{ request('dokter') == $d->id ? 'selected' : '' }}>
                    {{ $d->nama_dokter }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">-- Semua Status --</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="selesai" {{ request('status')=='selesai'?'selected':'' }}>Selesai</option>
            <option value="batal" {{ request('status')=='batal'?'selected':'' }}>Batal</option>
        </select>
    </div>

    <div class="col-md-3">
        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
    </div>

    <div class="col-md-2">
        <select name="sort" class="form-select">
            <option value="tanggal_asc">Tanggal ↑</option>
            <option value="tanggal_desc" {{ request('sort')=='tanggal_desc'?'selected':'' }}>Tanggal ↓</option>
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
            <th>Pasien</th>
            <th>Dokter</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($data as $k)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $k->nama_pelanggan }}</td>
            <td>{{ $k->nama_dokter }}</td>
            <td class="text-center">
                {{ \Carbon\Carbon::parse($k->tanggal)->format('d-m-Y') }}
            </td>
            <td class="text-center">
                {{ $k->jam_mulai }} - {{ $k->jam_selesai }}
            </td>
            <td class="text-center">
                <span class="badge bg-{{ 
                    $k->status=='pending' ? 'warning' :
                    ($k->status=='selesai' ? 'success' : 'danger') }}">
                    {{ ucfirst($k->status) }}
                </span>
            </td>
            <td class="text-center">
                ✅ <a href="{{ route('admin.konsultasi.detail', $k->id) }}"
                   class="btn btn-sm btn-info">
                    Detail
                </a>

                @if($k->status == 'pending')
                    <a href="{{ route('admin.konsultasi.detail', $k->id) }}"
                       class="btn btn-sm btn-primary mt-1">
                        Isi Hasil
                    </a>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted">
                Tidak ada data konsultasi
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $data->appends(request()->query())->links() }}

</div>
</div>
@endsection
