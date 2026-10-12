@extends('layouts.pelanggan')

@section('title', $treatment->nama ?? 'Detail Treatment')

@section('content')
<div class="container mt-4">
    @if($treatment)
    <div class="row">
        <div class="col-md-6 mb-3">
            <img src="{{ asset($treatment->gambar ?? 'storage/default.jpg') }}" 
                 class="img-fluid rounded shadow-sm" 
                 alt="{{ $treatment->nama }}">
        </div>
        <div class="col-md-6 d-flex flex-column">
            <h2 class="mb-3">{{ $treatment->nama }}</h2>
            <h4 class="text-success mb-3">Rp {{ number_format($treatment->harga, 0, ',', '.') }}</h4>
            <p class="mb-4">{{ $treatment->deskripsi }}</p>

            <div class="mt-auto">
                <a href="{{ route('pelanggan.treatment.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </div>
    </div>
    @else
        <div class="alert alert-warning">Treatment tidak ditemukan.</div>
    @endif
</div>
@endsection
