@extends('layouts.admin')
@section('title', 'Daftar Reservasi Treatment')

@section('content')
<h2 class="mb-4">Daftar Reservasi Treatment</h2>

<form method="GET" class="row g-3 mb-3">
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">-- Semua Status --</option>
            <option value="reserv" {{ $status=='reserv' ? 'selected' : '' }}>Reserv</option>
            <option value="berjalan" {{ $status=='berjalan' ? 'selected' : '' }}>Berjalan</option>
            <option value="selesai" {{ $status=='selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="batal treatment" {{ $status=='batal treatment' ? 'selected' : '' }}>Batal</option>
        </select>
    </div>
    <div class="col-md-3">
        <button class="btn btn-success">Filter</button>
    </div>
</form>

@if($appointments->isEmpty())
    <div class="alert alert-info">Belum ada reservasi treatment.</div>
@else
<div class="table-responsive">
<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th>ID Appointment</th>
            <th>Customer</th>
            <th>Tanggal Booking</th>
            <th>Status Treatment</th>
            <th>Treatment</th>
            <th>Terapis</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($appointments as $app)
        <tr>
            <td>{{ $app->id }}</td>

            <td>{{ $app->customer->nama_lengkap ?? '-' }}</td>

            {{-- Tanggal Booking --}}
            <td>
                @foreach($app->reservasiServices as $rs)
                    {{ \Carbon\Carbon::parse($rs->tanggal_booking)->format('d-m-Y') }}<br>
                @endforeach
            </td>

            {{-- Status Treatment --}}
            <td>
                @foreach($app->reservasiServices as $rs)
                    <span class="badge bg-{{ 
                        $rs->status == 'reserv' ? 'secondary' :
                        ($rs->status == 'berjalan' ? 'warning' :
                        ($rs->status == 'selesai' ? 'success' : 'danger'))
                    }}">
                        {{ ucfirst($rs->status) }}
                    </span><br>
                @endforeach
            </td>

            {{-- Treatment --}}
            <td>
                @foreach($app->reservasiServices as $rs)
                    {{ $rs->service->treatment->nama_treatment 
                        ?? $rs->service->nama_service 
                        ?? '-' }}<br>
                @endforeach
            </td>

            {{-- Terapis --}}
            <td>
                @foreach($app->reservasiServices as $rs)
                    {{ $rs->terapis->nama_terapis ?? '-' }}<br>
                @endforeach
            </td>

            {{-- AKSI (CUMA 1 TOMBOL) --}}
            <td class="text-center">
                <a href="{{ route('admin.reservasi.show', $app->id) }}"
                   class="btn btn-sm btn-primary">
                    Detail
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@endif
@endsection
