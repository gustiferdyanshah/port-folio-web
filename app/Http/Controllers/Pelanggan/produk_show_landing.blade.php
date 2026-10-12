@extends('layouts.beranda')

@section('title', 'Detail Produk')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <img src="{{ asset('images/' . $produk->image) }}"
             class="card-img-top"
             style="height:320px; object-fit:cover">

        <div class="card-body">
            <h4 class="fw-bold">{{ $produk->nama }}</h4>

            <p class="text-muted">{{ $produk->deskripsi }}</p>

            <p class="fw-bold text-success fs-5">
                Rp{{ number_format($produk->harga,0,',','.') }}
            </p>

            <a href="{{ route('pelanggan.produk.landing') }}"
               class="btn btn-secondary">
               ← Kembali
            </a>
        </div>
    </div>
</div>
@endsection
