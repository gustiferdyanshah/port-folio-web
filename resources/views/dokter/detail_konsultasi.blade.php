@extends('layouts.dokter')

@section('title','Detail Konsultasi')

@section('content')
<h4 class="mb-4">🩺 Detail Konsultasi Pasien</h4>

@php
    $selectedProducts = $data->rekomendasi_products
        ? array_map('intval', explode(',', $data->rekomendasi_products))
        : [];

    $selectedTreatments = $data->rekomendasi_treatments
        ? array_map('intval', explode(',', $data->rekomendasi_treatments))
        : [];
@endphp

<div class="card shadow-sm">
    <div class="card-body">

        <p><b>Nama:</b> {{ $data->nama_lengkap }}</p>
        <p><b>Jenis Kelamin:</b> {{ ucfirst($data->jenis_kelamin) }}</p>

        <form method="POST"
              action="{{ route('dokter.konsultasi.simpan', $data->id) }}">
            @csrf

            {{-- TIPE KULIT --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Tipe Kulit</label>
                <select name="skin_types" class="form-select" required>
                    @foreach(['kering','berminyak','normal','sensitif','kombinasi'] as $skin)
                        <option value="{{ $skin }}"
                            {{ $data->skin_types == $skin ? 'selected' : '' }}>
                            {{ ucfirst($skin) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- HASIL KONSULTASI --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Hasil Konsultasi</label>
                <textarea name="hasil_konsultasi"
                          class="form-control"
                          rows="3">{{ $data->hasil_konsultasi }}</textarea>
            </div>

            {{-- REKOMENDASI PRODUK --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Rekomendasi Produk</label>
                <div class="border rounded p-3">
                    @foreach($products as $p)
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="products[]"
                                   value="{{ $p->id }}"
                                   {{ in_array($p->id, $selectedProducts) ? 'checked' : '' }}>
                            <label class="form-check-label">
                                {{ $p->nama }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- REKOMENDASI TREATMENT --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Rekomendasi Treatment</label>
                <div class="border rounded p-3">
                    @foreach($treatments as $t)
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="treatments[]"
                                   value="{{ $t->id }}"
                                   {{ in_array($t->id, $selectedTreatments) ? 'checked' : '' }}>
                            <label class="form-check-label">
                                {{ $t->nama_treatment }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- STATUS --}}
            <div class="mb-4">
                <label class="form-label fw-bold">Status Konsultasi</label>
                <select name="status" class="form-select" required>
                    <option value="selesai" {{ $data->status == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>
                    <option value="batal" {{ $data->status == 'batal' ? 'selected' : '' }}>
                        Batal
                    </option>
                </select>
            </div>

            <button class="btn btn-success">💾 Simpan Konsultasi</button>
            <a href="{{ route('dokter.jadwal.konsultasi') }}"
               class="btn btn-secondary">Kembali</a>
        </form>

    </div>
</div>
@endsection
