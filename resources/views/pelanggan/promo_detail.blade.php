@extends('layouts.beranda')

@section('title', 'Detail Promo')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row align-items-start">
                @if($promo->gambar)
                <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end pe-md-3">
                    <img src="{{ asset($promo->gambar) }}"
                         class="img-fluid rounded"
                         alt="{{ $promo->nama_promo }}"
                         style="max-height: 350px; object-fit: contain;">
                </div>
                @endif

                <div class="col-12 col-md-7">
                    <h3 class="fw-bold mb-3">
                        {{ $promo->nama_promo }}
                    </h3>

                    <div class="mb-2">
                        <small class="text-muted">Tipe Promo</small><br>
                        <span class="fw-semibold">
                            {{ ucfirst($promo->tipe_promo) }}
                        </span>
                    </div>

                    @if($promo->diskon_persen)
                    <div class="mb-2">
                        <small class="text-muted">Diskon</small><br>
                        <span class="badge bg-danger fs-6">
                            {{ $promo->diskon_persen }}%
                        </span>
                    </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted">Periode Promo</small><br>
                        <span>
                            {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d/m/Y') }}
                            –
                            {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->format('d/m/Y') }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted">Deskripsi</small>
                        <p class="mt-1">
                            {{ $promo->deskripsi }}
                        </p>
                    </div>

                    <a href="{{ route('pelanggan.promos.index') }}"
                       class="btn btn-secondary">
                        ← Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
