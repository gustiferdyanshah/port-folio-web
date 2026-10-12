@extends('layouts.beranda')

@section('title', 'Produk Kami')

@section('content')
<h3 class="mb-4 text-success fw-bold">🛍️ Produk Kami</h3>

<div class="row">
@foreach($produk as $p)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <img src="{{ asset($p->image) }}"
                class="card-img-top"
                style="height:220px; object-fit:cover">

            <div class="card-body d-flex flex-column">
                <h5>{{ $p->nama }}</h5>

                <p class="text-muted">
                    {{ \Illuminate\Support\Str::limit($p->deskripsi, 80) }}
                </p>

                <p class="fw-bold text-success">
                    Rp{{ number_format($p->harga,0,',','.') }}
                </p>

                <a href="{{ route('pelanggan.produk.landing.show', $p->id) }}"
                   class="btn btn-outline-success mt-auto">
                   Detail Produk
                </a>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
