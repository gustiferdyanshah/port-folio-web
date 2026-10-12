@extends('layouts.admin')

@section('title','Detail Konsultasi')

@section('content')
<h4 class="mb-4">🧾 Detail Konsultasi</h4>

@php
    $selectedProductIds = collect(explode(',', (string) $data->rekomendasi_products))
        ->filter()
        ->map(fn ($id) => (int) trim($id))
        ->toArray();

    $selectedTreatmentIds = collect(explode(',', (string) $data->rekomendasi_treatments))
        ->filter()
        ->map(fn ($id) => (int) trim($id))
        ->toArray();
@endphp

<div class="card shadow-sm">
    <div class="card-body">

        {{-- INFO --}}
        <p><b>Pasien:</b> {{ $data->pasien }}</p>
        <p><b>Dokter:</b> {{ $data->dokter }}</p>
        <p><b>Tipe Kulit:</b> {{ ucfirst($data->skin_types) }}</p>
        <p>
            <b>Tanggal:</b>
            {{ $data->tanggal_konsultasi }}
            ({{ $data->jam_mulai }} - {{ $data->jam_selesai }})
        </p>

        <hr>

        {{-- HASIL KONSULTASI --}}
        <div class="mb-4">
            <label class="form-label fw-bold">📝 Hasil Konsultasi</label>
            <div class="border rounded p-3 bg-light">
                {{ $data->hasil_konsultasi ?? '-' }}
            </div>
        </div>

        {{-- FORM AJUKAN --}}
        <form method="POST" action="{{ route('admin.konsultasi.ajukan', $data->id) }}">
            @csrf

            {{-- PRODUK --}}
            <div class="mb-4">
                <label class="form-label fw-bold">🧴 Rekomendasi Produk</label>
                <div class="border rounded p-3" style="max-height:300px; overflow-y:auto;">
                    @foreach($products as $product)
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="products[]"
                                   value="{{ $product->id }}"
                                   {{ in_array($product->id, $selectedProductIds) ? 'checked' : '' }}>
                            <label class="form-check-label">
                                {{ $product->nama }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- TREATMENT --}}
            <div class="mb-4">
                <label class="form-label fw-bold">💆 Rekomendasi Treatment</label>
                <div class="border rounded p-3" style="max-height:300px; overflow-y:auto;">
                    @foreach($treatments as $treatment)
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="treatments[]"
                                   value="{{ $treatment->id }}"
                                   {{ in_array($treatment->id, $selectedTreatmentIds) ? 'checked' : '' }}>
                            <label class="form-check-label">
                                {{ $treatment->nama_treatment }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ACTION --}}
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success px-4">
                    ➕ Ajukan
                </button>

                <button type="button"
                        class="btn btn-danger px-4"
                        onclick="if(confirm('Yakin ingin membatalkan konsultasi ini?')) document.getElementById('form-batal').submit();">
                    ❌ Batal
                </button>
            </div>
        </form>

        {{-- FORM BATAL --}}
        <form id="form-batal"
              method="POST"
              action="{{ route('admin.konsultasi.batal', $data->id) }}">
            @csrf
            @method('PUT')
        </form>

    </div>
</div>
@endsection
