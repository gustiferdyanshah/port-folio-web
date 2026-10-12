@extends('layouts.beranda')

@section('title', 'Detail Produk')

@section('content')
<div class="container">
   <div class="container mt-4">
    <div class="card shadow-sm p-4">
        <div class="row align-items-center">
            <div class="col-md-5 text-center">
                <img src="{{ asset($produk->image) }}"
                     class="img-fluid rounded"
                     style="max-height: 320px; object-fit: contain;">
            </div>

            <div class="col-md-7">
                <h4 class="fw-bold">{{ $produk->nama }}</h4>

                <p class="text-muted mt-2">
                    {{ $produk->deskripsi }}
                </p>

                <p class="fw-bold text-success fs-4">
                    Rp{{ number_format($produk->harga,0,',','.') }}
                </p>

                <a href="{{ route('pelanggan.produk.landing') }}"
                   class="btn btn-secondary mt-3">
                   Kembali
                </a>
            </div>

        </div>
    </div>
</div>

@endsection
