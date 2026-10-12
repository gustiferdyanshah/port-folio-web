@extends('layouts.admin')
@section('title', 'Isi Hasil Konsultasi')

@section('content')
<h2 class="mb-4">Form Hasil Konsultasi</h2>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <p><strong>Nama Pelanggan:</strong> {{ $konsultasi->nama_pelanggan ?? '-' }}</p>
        <p><strong>No. WhatsApp:</strong> {{ $konsultasi->no_wa ?? '-' }}</p>
        <p><strong>Dokter:</strong> {{ $konsultasi->nama_dokter ?? '-' }}</p>
        <p><strong>Jadwal:</strong> 
            {{ $konsultasi->tanggal ?? '-' }} 
            {{ $konsultasi->jam_mulai ?? '' }} - {{ $konsultasi->jam_selesai ?? '' }}
        </p>
    </div>
</div>

<form action="/admin/konsultasi/{{ $konsultasi->id }}/isi" method="POST">
    @csrf

    <div class="mb-3">
        <label for="hasil_konsultasi" class="form-label">Catatan Hasil Konsultasi</label>
        <textarea name="hasil_konsultasi" id="hasil_konsultasi" rows="5" class="form-control" required>{{ old('hasil_konsultasi', $konsultasi->hasil_konsultasi) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status Konsultasi</label>
        <select name="status" id="status" class="form-select" required>
            <option value="">-- Pilih Status --</option>
            <option value="selesai" {{ $konsultasi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="batal" {{ $konsultasi->status == 'batal' ? 'selected' : '' }}>Batal</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="tanggal_berikutnya" class="form-label">Tanggal Konsultasi Berikutnya (Opsional)</label>
        <input 
            type="date" 
            name="tanggal_berikutnya" 
            id="tanggal_berikutnya" 
            class="form-control"
            value="{{ old('tanggal_berikutnya', $konsultasi->tanggal_berikutnya ?? date('Y-m-d')) }}"
            min="{{ date('Y-m-d') }}"
        >
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="/admin/konsultasi" class="btn btn-secondary">Kembali</a>
</form>
@endsection
