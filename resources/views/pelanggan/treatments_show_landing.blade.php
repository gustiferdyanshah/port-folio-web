@extends('layouts.beranda')

@section('title', 'Detail Treatment')

@section('content')
<div class="container py-4">
    <div class="row align-items-center">
        <div class="col-md-6 mb-3">
            <img
                src="{{ asset($treatment->gambar ?? 'images/default.jpg') }}"
                class="img-fluid rounded shadow"
                alt="{{ $treatment->nama }}"
            >
        </div>

        <div class="col-md-6">
            <h3 class="fw-bold text-success">{{ $treatment->nama }}</h3>

            <p class="text-muted mt-3">
                {{ $treatment->deskripsi }}
            </p>

            <h5 class="fw-bold text-success mt-4">
                Rp{{ number_format($treatment->harga,0,',','.') }}
            </h5>

            <div class="mt-4">
                @if(auth('pelanggan')->check())
                    <a href="#" class="btn btn-success">
                        Booking Sekarang
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-success">
                        Login untuk Treatment
                    </a>
                @endif

                <a href="{{ route('pelanggan.treatments.landing') }}"
                   class="btn btn-secondary ms-2">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
