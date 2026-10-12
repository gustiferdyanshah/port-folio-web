<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 15px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar .active {
            background-color: #0d6efd;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar p-0">
            <h4 class="text-center py-3 bg-dark mb-0">Admin</h4>
            <a href="/admin/dashboard" class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('admin.produk.index') }}" class="{{ Request::is('admin/produk*') ? 'active' : '' }}">📦 Produk</a>
            <a href="{{ route('admin.promos.index') }}" class="{{ Request::is('admin/promos*') ? 'active' : '' }}">🏷️ Kelola Promo</a>
            <a href="/admin/dokter" class="{{ Request::is('admin/dokter*') ? 'active' : '' }}">➕ Tambah Dokter</a>
            <a href="{{ route('admin.dokter.jadwal') }}"class="{{ Request::is('admin/dokter/jadwal*') ? 'active' : '' }}">🗓️ Jadwal Dokter</a>
            <a href="/admin/dokter/register" class="{{ Request::is('admin/dokter/register') ? 'active' : '' }}">➕ Akun Dokter</a>
            <a href="/admin/terapis" class="{{ Request::is('admin/terapis*') ? 'active' : '' }}">👩‍⚕️ Data Terapis</a>
            <a href="{{ route('admin.terapis.ketersediaan') }}"class="{{ Request::is('admin/terapis*') ? 'active' : '' }}">🧑‍⚕️ Ketersediaan Terapis</a>
            <a href="/admin/konsultasi" class="{{ Request::is('admin/konsultasi*') ? 'active' : '' }}">📋 Hasil Konsultasi</a>
            <a href="{{ route('admin.reservasi.index') }}" class="{{ Request::is('admin/reservasi*') ? 'active' : '' }}">📅 Daftar Reservasi</a>
            <a href="/admin/treatment" class="{{ Request::is('admin/treatment*') ? 'active' : '' }}">💆 Treatment</a>
            <a href="/admin/transaksi" class="{{ Request::is('admin/transaksi*') ? 'active' : '' }}">💰 Transaksi</a>
            <a href="/logout" class="text-danger mt-3">🚪 Logout</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4 bg-light">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
