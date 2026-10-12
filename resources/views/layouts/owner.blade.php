<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Owner')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; }
        .sidebar {
            min-height: 100vh;
            background-color: #1f2933;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 15px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #374151;
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
            <h4 class="text-center py-3 bg-dark mb-0">👑 Owner</h4>

            <a href="{{ route('owner.dashboard') }}"
               class="{{ Request::is('owner/dashboard') ? 'active' : '' }}">
                🏠 Dashboard
            </a>

            <a href="{{ route('owner.laporan.pendapatan') }}"
               class="{{ Request::is('owner/laporan/pendapatan*') ? 'active' : '' }}">
                📊 Laporan Pendapatan
            </a>
            <a href="{{ route('owner.produk.index') }}" class="{{ Request::is('owner/produk*') ? 'active' : '' }}">
    📦 Produk
</a>


            <a href="/owner/logout" class="text-danger mt-3">
                🚪 Logout
            </a>
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
