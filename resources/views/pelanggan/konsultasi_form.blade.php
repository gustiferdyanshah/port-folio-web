@extends('layouts.pelanggan')
@section('title', 'Form Jadwal Konsultasi')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Form Jadwal Konsultasi</h4>
    </div>
    <div class="card-body">

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
        <div class="card border-warning shadow-sm mb-3">
            <div class="card-header bg-warning fw-bold">
                Pemberitahuan
            </div>
            <div class="card-body text-center">
                {{ session('warning') }}
            </div>
        </div>
        @endif
        <form method="POST" action="/pelanggan/konsultasi">
            @csrf

            <div class="mb-3">
                <label for="doctor_id" class="form-label">Pilih Dokter</label>
                <select name="doctor_id" id="doctor_id" class="form-select" required>
                    <option value="">-- Pilih Dokter --</option>
                    @forelse($dokter as $d)
                        <option value="{{ $d->id }}">{{ $d->nama_dokter }}</option>
                    @empty
                        <option value="">Tidak ada dokter tersedia</option>
                    @endforelse
                </select>
            </div>

            <div class="mb-3">
                <label for="schedule_id" class="form-label">Pilih Jadwal</label>
                <select name="schedule_id" id="schedule_id" class="form-select" required>
                    <option value="">-- Pilih Jadwal --</option>
                    @forelse($jadwal as $s)
                        <option value="{{ $s->id }}">
                            Tanggal: {{ $s->tanggal }} | Jam: {{ $s->jam_mulai }} - {{ $s->jam_selesai }} | Kuota: {{ $s->kuota }}
                        </option>
                    @empty
                        <option value="">Tidak ada jadwal tersedia</option>
                    @endforelse
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan Jadwal</button>
            <a href="/pelanggan/dashboard" class="btn btn-secondary ms-2">Batal</a>
        </form>

    </div>
</div>
@endsection
