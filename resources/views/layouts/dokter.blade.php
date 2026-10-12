<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dokter')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { min-height: 100vh; }
        .sidebar {
            min-height: 100vh;
            background-color: #0d6efd;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 15px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #0b5ed7;
        }
        .sidebar .active {
            background-color: #084298;
        }
    </style>
</head>
<body>

@php
    use Illuminate\Support\Facades\Auth;
    $doctor = Auth::guard('doctor')->user();
@endphp

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar Dokter -->
        <div class="col-md-3 col-lg-2 sidebar p-0">
            <h4 class="text-center py-3 bg-primary mb-0">
                Dokter Panel
            </h4>

            @if($doctor)
                <div class="text-center py-2 border-bottom">
                    👨‍⚕️ {{ $doctor->nama_dokter }}
                </div>
            @endif

            <a href="{{ route('dokter.dashboard') }}"
               class="{{ Request::is('dokter/dashboard') ? 'active' : '' }}">
                🏠 Dashboard
            </a>
            
            <a href="{{ route('dokter.jadwal.konsultasi') }}"
                class="{{ Request::is('dokter/jadwal-konsultasi') ? 'active' : '' }}">
                    🗓️ Jadwal Konsultasi
            </a>

            <form action="{{ route('dokter.logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-warning w-100">
                    🚪 Logout
                </button>
            </form>
        </div>

        <div class="col-md-9 col-lg-10 p-4 bg-light">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
