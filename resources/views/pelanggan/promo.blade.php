@extends('layouts.beranda')

@section('title', 'Promo Aktif')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Promo Aktif</h2>

    <div class="row">
        @forelse($promos as $promo)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($promo->image)
                        <img src="{{ asset($promo->image) }}"
                             class="card-img-top"
                             style="height: 180px; object-fit: cover;"
                             alt="{{ $promo->nama_promo }}">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $promo->nama_promo }}</h5>

                        <p class="card-text mb-1">
                            <strong>Tipe:</strong> {{ ucfirst($promo->tipe_promo) }}
                        </p>

                        @if($promo->diskon_persen)
                            <p class="card-text mb-1">
                                <strong>Diskon:</strong> {{ $promo->diskon_persen }}%
                            </p>
                        @endif

                        <p class="card-text mb-2">
                            <strong>Periode:</strong><br>
                            {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d/m/Y') }}
                            –
                            {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->format('d/m/Y') }}
                        </p>

                        <p class="card-text text-truncate">
                            {{ $promo->deskripsi }}
                        </p>

                        <div class="mt-auto">
                            <a href="{{ route('pelanggan.promo.show', $promo->id) }}"
                               class="btn btn-primary btn-sm">
                                Detail
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <p class="text-center text-muted">
                Tidak ada promo aktif saat ini.
            </p>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $promos->links() }}
    </div>
</div>
@endsection
