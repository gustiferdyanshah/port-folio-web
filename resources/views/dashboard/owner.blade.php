@extends('layouts.owner')

@section('title', 'Dashboard Owner')

@section('content')

<h4 class="mb-1">📊 Dashboard Owner</h4>
<p class="text-muted mb-4">
    Selamat datang, <strong>{{ Auth::user()->nama ?? 'Owner' }}</strong>
</p>

{{-- ================= KPI ================= --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted">Total Pendapatan</small>
                <h5 class="text-success fw-bold">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </h5>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted">Total Transaksi</small>
                <h5 class="fw-bold">{{ $totalTransaksi }}</h5>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted">Total Customer</small>
                <h5 class="fw-bold">{{ $totalCustomer }}</h5>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted">Total Reservasi</small>
                <h5 class="fw-bold">{{ $totalReservasi }}</h5>
            </div>
        </div>
    </div>
</div>

{{-- ================= GRAFIK & SIDEBAR ================= --}}
<div class="row g-3">

    {{-- GRAFIK --}}
    <div class="col-lg-8">
        <div class="card shadow-sm h-100">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">📈 Grafik Pendapatan</h6>

                    <form method="GET" class="mb-0 d-flex align-items-center gap-2">
                        <select name="filter" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="weekly" {{ $filter=='weekly' ? 'selected' : '' }}>Mingguan</option>
                            <option value="monthly" {{ $filter=='monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="yearly" {{ $filter=='yearly' ? 'selected' : '' }}>Tahunan</option>
                        </select>

                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control form-control-sm" />
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control form-control-sm" />
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    </form>
                </div>

                <div style="height: 250px; max-width: 100%;">
                    <canvas id="pendapatanChart"></canvas>
                </div>

            </div>
        </div>
    </div>

    {{-- SIDEBAR --}}
    <div class="col-lg-4">

        {{-- PRODUK --}}
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">🏆 Top 5 Produk</h6>

                <ul class="list-group list-group-flush">
                    @forelse ($topProduk as $item)
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>{{ $item->nama }}</span>
                            <span class="badge bg-primary">{{ $item->total }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Data kosong</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- TREATMENT --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">💆‍♀️ Top 5 Treatment</h6>

                <ul class="list-group list-group-flush">
                    @forelse ($topTreatment as $item)
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>{{ $item->nama_treatment }}</span>
                            <span class="badge bg-success">{{ $item->total }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Data kosong</li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('pendapatanChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode($values) !!},
                backgroundColor: '#0d6efd',
                borderRadius: 6,
                 barThickness: 26, // opsional, bisa dihilangkan biar otomatis
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    categoryPercentage: 0.4,  // bikin kategori lebih sempit
                    barPercentage: 0.6        // bikin batang lebih rapat dan tipis
                },
                y: {
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    },
                    beginAtZero: true
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

@endsection
