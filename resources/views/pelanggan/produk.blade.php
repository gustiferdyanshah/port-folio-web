@extends('layouts.pelanggan')

@section('title', 'Produk Kami')

@section('content')
<div class="container">
    <h3 class="mb-4 text-success fw-bold">🛍️ Produk Kami</h3>

    <div class="row">
        @foreach($produks as $produk)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset($produk->image) }}" 
                         class="card-img-top" 
                         style="height:220px; object-fit:cover">
                    {{--
                    <img src="{{ asset($p->image) }}" 
                        class="card-img-top" 
                        alt="{{ $p->nama }}" 
                        style="height: 200px; object-fit: cover;">
                    --}}
                    <div class="card-body d-flex flex-column">
                        <h5>{{ $produk->nama }}</h5>

                        <p class="text-muted">
                            {{ \Illuminate\Support\Str::limit($produk->deskripsi, 80) }}
                        </p>

                        <p class="fw-bold text-success">
                            Rp{{ number_format($produk->harga,0,',','.') }}
                        </p>

                        <a href="{{ route('produk.show', $produk->id) }}" 
                        class="btn btn-outline-success mt-auto">
                            Detail Produk
                        </a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $produks->links() }}
</div>
@endsection
