<!-- resources/views/layouts/pelanggan.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Pelanggan')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
        }
        .navbar-brand {
            font-weight: bold;
            color: #198754;
        }
        .nav-link {
            color: #333 !important;
            margin-right: 15px;
        }
        .nav-link:hover {
            color: #198754 !important;
        }
        .btn-green {
            background-color: #198754;
            color: white;
        }
        .btn-green:hover {
            background-color: #157347;
        }
    </style>
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-custom px-4 py-2 shadow-sm">
    <div class="container-fluid">
        <!-- Logo kiri -->
        <a class="navbar-brand d-flex align-items-center" href="/pelanggan/dashboard">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" height="32" class="me-2">
            <span class="fw-bold text-success">Rumah Cantik Anda</span>
        </a>

        <!-- Toggler Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu kanan -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="/pelanggan/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pelanggan/konsultasi">Jadwal Konsultasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pelanggan/reservasi/buat">Reservasi Treatment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pelanggan/transaksi">Transaksi</a>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pelanggan.produk.index') }}">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pelanggan.treatment.index') }}">Treatment</a>
                </li>

                <li class="nav-item ms-2">
                    <a href="/pelanggan/logout" class="btn btn-green btn-sm">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-4 mb-5">
    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
