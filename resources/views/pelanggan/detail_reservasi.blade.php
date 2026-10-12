@extends('layouts.pelanggan')

@section('title', 'Detail Reservasi Treatment')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-receipt me-2"></i>
                        Detail Reservasi Treatment
                    </h4>
                </div>

                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">👤 Data Pasien</h6>
                    <table class="table table-sm">
                        <tr>
                            <th width="35%">Nama Pasien</th>
                            <td>{{ $reservasi->service->appointment->customer->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Dokter</th>
                            <td>{{ $reservasi->service->appointment->dokter ?? '-' }}</td>
                        </tr>
                    </table>

                    <hr>

                    <h6 class="fw-bold mb-2">📝 Hasil Konsultasi Dokter</h6>
                    <div class="form-control bg-light mb-4">
                        {{ $reservasi->service->appointment->hasil_konsultasi ?? '-' }}
                    </div>

                    @php
                        $treatments = \App\Models\Treatments::whereIn(
                            'id',
                            explode(',', (string) $reservasi->service->appointment->rekomendasi_treatments)
                        )->get();

                        $totalDurasi = $treatments->sum('durasi');
                    @endphp

                    <h6 class="fw-bold mb-2">💆 Treatment</h6>
                    <div class="form-control bg-light mb-3">
                        @foreach($treatments as $t)
                            <div>
                                • {{ $t->nama_treatment }} ({{ $t->durasi }} menit)
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <b>Total Durasi:</b> {{ $totalDurasi }} menit
                    </div>

                    @php
                        $products = \App\Models\Produk::whereIn(
                            'id',
                            explode(',', (string) $reservasi->service->appointment->rekomendasi_products)
                        )->get();
                    @endphp

                    <h6 class="fw-bold mb-2">🧴 Rekomendasi Produk</h6>
                    <div class="form-control bg-light mb-4">
                        @foreach($products as $p)
                            <div>• {{ $p->nama }}</div>
                        @endforeach
                    </div>

                    <hr>
                    <h6 class="fw-bold mb-3">📅 Jadwal Reservasi</h6>
                    <table class="table table-sm">
                        <tr>
                            <th width="35%">Tanggal</th>
                            <td>{{ $reservasi->tanggal_booking }}</td>
                        </tr>
                        <tr>
                            <th>Jam</th>
                            <td>{{ $reservasi->jam_booking }} - {{ $reservasi->jam_ending }}</td>
                        </tr>
                        <tr>
                            <th>Terapis</th>
                            <td>{{ $reservasi->terapis->nama_terapis }}</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('pelanggan.reservasi.index') }}"
                           class="btn btn-outline-secondary px-4">
                            Kembali
                        </a>

                       
                        <form action="{{ route('pelanggan.reservasi.konfirmasi.store', $reservasi->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success px-4">Konfirmasi & Lanjut</button>
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
