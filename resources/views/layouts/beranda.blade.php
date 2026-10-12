<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Klinik Rumah Cantik Anda')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand img {
            height: 40px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom">
    <div class="container-fluid px-4">
        <!-- Logo Kiri -->
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="me-2">
            <span class="fw-bold text-success">Klinik Rumah Cantik Anda</span>
        </a>

        <!-- Button Toggle Responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Kanan -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
            <ul class="navbar-nav mb-2 mb-lg-0 align-items-center gap-3">
                <li class="nav-item">
                    <a class="nav-link text-dark fw-medium"href="{{ route('pelanggan.produk.landing') }}">Produk</a>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-medium"href="{{ route('pelanggan.treatments.landing') }}">Perawatan Kami</a>
                </li>
                <li class="nav-item">
                     <a class="nav-link text-dark fw-medium" href="{{ route('pelanggan.promos.index') }}">Promo</a>
                </li>


                @auth('pelanggan')
                    <li class="nav-item">
                        <form action="/pelanggan/logout" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-success btn-sm">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-success btn-sm" href="/pelanggan/login">Login/Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container py-4">
    @yield('content')
</div>

<!-- Scripts -->
@yield('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
