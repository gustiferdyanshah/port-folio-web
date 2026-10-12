@extends('layouts.pelanggan')
@section('title', 'Edit Jadwal Konsultasi')

@section('content')
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Edit Jadwal Konsultasi</h4>
        </div>
        <div class="card-body">

            <form method="POST" action="/pelanggan/konsultasi/{{ $appointment->id }}/update">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Jadwal Saat Ini</label>
                    <input type="text" class="form-control" 
                        value="{{ $current_schedule->tanggal }} {{ $current_schedule->jam_mulai }} - {{ $current_schedule->jam_selesai }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="schedule_id" class="form-label">Jadwal Baru</label>
                    <select name="schedule_id" id="schedule_id" class="form-select" required>
                        <option value="">-- Pilih Jadwal Baru --</option>
                        @foreach($schedules as $s)
                            <option value="{{ $s->id }}">
                                {{ $s->tanggal }} ({{ $s->jam_mulai }} - {{ $s->jam_selesai }}) - Kuota: {{ $s->kuota }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="/pelanggan/dashboard" class="btn btn-secondary ms-2">Kembali ke Dashboard</a>
            </form>

        </div>
    </div>
@endsection
