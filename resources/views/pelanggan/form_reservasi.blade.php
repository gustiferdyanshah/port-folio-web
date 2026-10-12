@extends('layouts.pelanggan')

@section('title', 'Form Reservasi Treatment')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-check me-2"></i>
                        Form Reservasi Treatment
                    </h4>
                </div>

                <div class="card-body p-4">

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('pelanggan.reservasi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="appointments_id" value="{{ $service->appointments_doctor_id }}">
                        <input type="hidden" name="services_id" value="{{ $service->id }}">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                📝 Hasil Konsultasi Dokter
                            </label>
                            <div class="form-control bg-light">
                                {{ $service->appointment->hasil_konsultasi ?? '-' }}
                            </div>
                        </div>
                        @php
                            $treatments = \App\Models\Treatments::whereIn(
                                'id',
                                explode(',', (string) $service->appointment->rekomendasi_treatments)
                            )->get();

                            $totalDurasi = $treatments->sum('durasi') ?? 0;
                        @endphp

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                💆 Rekomendasi Treatment
                            </label>
                            <div class="form-control bg-light" style="min-height:90px">
                                @forelse($treatments as $t)
                                    <div>
                                        • {{ $t->nama_treatment }} ({{ $t->durasi }} menit)
                                    </div>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                ⏱ Total Durasi Treatment
                            </label>
                            <div class="form-control bg-light">
                                {{ $totalDurasi }} menit
                            </div>
                        </div>
                        @php
                            $products = \App\Models\Produk::whereIn(
                                'id',
                                explode(',', (string) $service->appointment->rekomendasi_products)
                            )->get();
                        @endphp

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                🧴 Rekomendasi Produk
                            </label>
                            <div class="form-control bg-light" style="min-height:80px">
                                @forelse($products as $p)
                                    <div>• {{ $p->nama }}</div>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Reservasi</label>
                            <input type="date"
                                   name="tanggal_booking"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jam Mulai</label>
                                <input type="time"
                                       name="jam_booking"
                                       id="jam_booking"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jam Selesai</label>
                                <div id="jam_selesai" class="form-control bg-light">
                                    00:00
                                </div>
                                <input type="hidden"
                                       name="jam_selesai"
                                       id="jam_selesai_hidden"
                                       value="00:00">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Pilih Terapis</label>
                            <select name="terapis_id" class="form-select" required>
                                <option value="">-- Pilih Terapis --</option>
                                @foreach($terapis as $t)
                                    <option value="{{ $t->id }}">
                                        {{ $t->nama_terapis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pelanggan.reservasi.index') }}"
                               class="btn btn-outline-secondary px-4">
                                Batal
                            </a>

                            <button type="submit"
                                    class="btn btn-success px-4">
                                Ajukan Reservasi
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const totalDurasi = parseInt({{ $totalDurasi ?? 0 }});
    const jamBooking = document.getElementById('jam_booking');
    const jamSelesai = document.getElementById('jam_selesai');
    const jamSelesaiHidden = document.getElementById('jam_selesai_hidden');

    function updateJamSelesai() {
        if (!jamBooking.value) {
            jamSelesai.textContent = '00:00';
            jamSelesaiHidden.value = '00:00';
            return;
        }

        const [jam, menit] = jamBooking.value.split(':').map(Number);
        let totalMenit = (jam * 60) + menit + totalDurasi;
        let jamAkhir = Math.floor(totalMenit / 60) % 24;
        let menitAkhir = totalMenit % 60;

        const hasil =
            String(jamAkhir).padStart(2, '0') + ':' +
            String(menitAkhir).padStart(2, '0');

        jamSelesai.textContent = hasil;
        jamSelesaiHidden.value = hasil;
    }

    jamBooking.addEventListener('input', updateJamSelesai);
    updateJamSelesai();
});
</script>
@endpush
