@extends('layouts.pelanggan')
@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="text-center mb-5">
    <h2 class="text-success fw-bold">
        Selamat datang, {{ $user->nama_lengkap ?? 'Pelanggan' }}
    </h2>
    <p class="text-muted">
        Nikmati layanan konsultasi, treatment, produk terbaik, dan promo menarik dari kami.
    </p>
</div>

@if(isset($promo) && $promo->isNotEmpty())
<h4 class="mt-5 mb-3 text-success fw-bold"> Promo Saat Ini</h4>
<div class="row">
@foreach($promo as $p)
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">

            @if($p->gambar)
                <img src="{{ asset($p->gambar) }}"
                    class="card-img-top"
                    alt="{{ $p->nama_promo }}"
                    style="height:200px; object-fit:cover;">
            @endif


            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $p->nama_promo }}</h5>
                <p class="card-text text-muted">
                    {{ Str::limit($p->deskripsi, 100) }}
                </p>
                <p class="fw-bold text-success">
                    Diskon: {{ $p->diskon_persen ?? 0 }}%
                </p>
            </div>
        </div>
    </div>
@endforeach
</div>
@endif

@endsection
