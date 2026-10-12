@extends('layouts.beranda')

@section('title', 'Treatment Kami')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 text-success fw-bold">💆‍♀️ Treatment Kami</h3>

    <div class="row">
        @forelse($treatments as $treatment)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img
                        src="{{ asset($treatment->gambar ?? 'images/default.jpg') }}"
                        class="card-img-top"
                        style="height:220px; object-fit:cover"
                        alt="{{ $treatment->nama }}"
                    >

                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold">{{ $treatment->nama }}</h5>

                        <p class="text-muted">
                            {{ \Illuminate\Support\Str::limit($treatment->deskripsi, 80) }}
                        </p>

                        <p class="fw-bold text-success">
                            Rp{{ number_format($treatment->harga,0,',','.') }}
                        </p>

                        <a href="{{ route('pelanggan.treatment.landing.show', $treatment->id) }}"
                           class="btn btn-outline-success mt-auto">
                            Detail Treatment
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada treatment tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
