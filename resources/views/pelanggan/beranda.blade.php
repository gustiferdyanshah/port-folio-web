@extends('layouts.beranda')

@section('title', 'Beranda')

@section('content')
<div class="text-center mt-5">
    <h1 class="fw-bold text-success">Selamat Datang di Klinik Rumah Cantik Anda</h1>
</div>

<div class="row my-5 align-items-center">
    <div class="col-md-6 mb-3">
        <img src="{{ asset('images/cover.jpeg') }}" alt="Klinik" class="img-fluid rounded shadow">
    </div>
    <div class="col-md-6">
        <p class="text-muted fst-italic">
            Spesialis dalam perawatan wajah, Klinik Rumah Cantik menyediakan layanan estetika yang aman, ideal, dan terpercaya.
        </p>
        <p class="text-muted fst-italic">
            Klinik Rumah Cantik Anda berkomitmen memberikan layanan perawatan kecantikan terbaik dengan sepenuh hati kepada pelanggan.
        </p>
        <p class="text-muted fst-italic">
            Tidak hanya itu, klinik ini juga menyediakan berbagai produk dan perawatan unggulan yang telah mendapatkan kepercayaan masyarakat.
        </p>
    </div>
</div>

<h3 class="mt-5 mb-3 text-success fw-bold">🛍️ Produk Kami</h3>
<div class="row">
    @forelse($produk as $p)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <img src="{{ asset($p->image) }}" 
                        class="card-img-top" 
                        alt="{{ $p->nama }}" 
                        style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $p->nama }}</h5>
                    <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($p->deskripsi, 100) }}</p>
                    <p class="card-text fw-bold text-success">Rp{{ number_format($p->harga, 0, ',', '.') }}</p>
                 
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <p class="text-muted">Belum ada produk tersedia.</p>
        </div>
    @endforelse
</div>

<div class="container mt-5 text-center">
    <h4 class="fw-bold mb-4">Payment Method</h4>
    <div class="row justify-content-center g-4 align-items-center">
        @foreach(['bca', 'cash', 'qris'] as $bank)
            <div class="col-auto">
                <img src="{{ asset('images/payments/' . $bank . '.jpg') }}" alt="{{ strtoupper($bank) }}" style="height: 80px;">
            </div>
        @endforeach
    </div>
</div>


<footer class="mt-5 py-5 border-top bg-white">
    <div class="container">
        <div class="row gy-4">
            <!-- Logo -->
            <div class="col-md-3 text-md-start text-center">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 50px;">
                <p class="mt-3 mb-0 text-muted">
                    ADMIN: 08153252353 (Whatsapp)<br>
                    (07.00 — 20.00 WIB)
                </p>
            </div>

            <div class="col-md-3 text-md-start text-center">
                <h6 class="fw-bold text-warning">Alamat</h6>
                <p class="text-muted small mb-0">
                    500 meter baratnya Balai,<br>
                    selatan jalan, Sumber Kolak,<br>
                    Kabupaten Situbondo,<br>
                    Jawa Timur 68351
                </p>
            </div>

            <div class="col-md-3 text-md-start text-center">
                <h6 class="fw-bold text-warning">Jam Operasional</h6>
                <p class="text-muted small mb-0">
                    Selasa - Minggu : 09:00 - 18:00<br>
                </p>
            </div>

            <div class="col-md-3 text-md-start text-center">
                <h6 class="fw-bold text-warning">Social Media</h6>
                <div class="d-flex flex-column gap-2 justify-content-start text-start">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-instagram fs-5 text-danger"></i>
                        <span class="text-muted small">rumahcantik.anda</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-tiktok fs-5 text-dark"></i>
                        <span class="text-muted small">@rumahcantikanda</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection
