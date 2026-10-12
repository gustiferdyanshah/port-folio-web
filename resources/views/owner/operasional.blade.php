@extends('layouts.owner')

@section('title', 'Monitoring Operasional')

@section('content')

<h4 class="mb-3">📋 Monitoring Operasional</h4>

<form method="GET" class="mb-4 d-flex gap-2 align-items-center flex-wrap">
    <label for="start_date" class="form-label mb-0">Dari:</label>
    <input type="date" name="start_date" id="start_date" value="{{ $startDate ?? '' }}" class="form-control form-control-sm" />

    <label for="end_date" class="form-label mb-0">Sampai:</label>
    <input type="date" name="end_date" id="end_date" value="{{ $endDate ?? '' }}" class="form-control form-control-sm" />

    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
</form>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6>Total Reservasi</h6>
                <h3>{{ $totalReservasi }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6>Reservasi Berjalan</h6>
                <h3>{{ $reservasiBerjalan }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6>Reservasi Selesai</h6>
                <h3>{{ $reservasiSelesai }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h6>Reservasi Batal</h6>
                <h3>{{ $reservasiBatal }}</h3>
            </div>
        </div>
    </div>
</div>

<h5 class="mb-3">Jadwal Terapi</h5>

@if($jadwalTerapi->isEmpty())
    <p class="text-muted">Tidak ada jadwal terapi pada rentang tanggal ini.</p>
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal Booking</th>
                <th>Terapis</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Nama Treatment</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwalTerapi as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y') }}</td>
                    <td>{{ $item->terapis_nama }}</td>
                    <td>{{ $item->jam_booking }}</td>
                    <td>{{ $item->jam_ending }}</td>
                    <td>{{ $item->nama_treatment }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection
