@extends('layouts.admin')

@section('title','Dashboard Admin')

@section('content')

<h4 class="mb-3">
    Halo, <span class="text-primary">{{ $user->nama ?? 'Admin' }}</span>
    <small class="text-muted fs-6">(Role: admin)</small>
</h4>

{{-- ================= STAT ================= --}}
<div class="row mb-3">
    <div class="col-md-3 col-6 mb-2">
        <div class="card shadow-sm text-center p-2 h-100">
            <div class="card-body py-2">
                <small class="text-muted">👥 Pelanggan Aktif</small>
                <h5 class="fw-bold mb-0">{{ $pelangganAktif }}</h5>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6 mb-2">
        <div class="card shadow-sm text-center p-2 h-100">
            <div class="card-body py-2">
                <small class="text-muted">🎉 Promo Aktif</small>
                <h5 class="fw-bold mb-0">{{ $promoAktif }}</h5>
            </div>
        </div>
    </div>
</div>

{{-- ================= PENDAPATAN ================= --}}
<div class="card shadow-sm mb-4">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-bold mb-0">💰 Pendapatan</h6>
            <form method="GET">
                <select name="filter" onchange="this.form.submit()" class="form-select form-select-sm">
                    <option value="daily" {{ $filter=='daily'?'selected':'' }}>Harian</option>
                    <option value="weekly" {{ $filter=='weekly'?'selected':'' }}>Mingguan</option>
                    <option value="monthly" {{ $filter=='monthly'?'selected':'' }}>Bulanan</option>
                    <option value="yearly" {{ $filter=='yearly'?'selected':'' }}>Tahunan</option>
                </select>
            </form>
        </div>
        <div style="height:360px">
            <canvas id="pendapatanChart"></canvas>
        </div>
    </div>
</div>

{{-- ================= PRODUK TERFAVORIT ================= --}}
<div class="card shadow-sm mb-3">
    <div class="card-body p-3">
        <h6 class="fw-bold mb-2">🛍️ 5 Produk Terfavorit</h6>

        @if($produk->isEmpty())
            <div class="alert alert-info py-2 mb-0">Belum ada produk.</div>
        @else
        <div class="table-responsive">
            <table class="table table-sm table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40">No</th>
                        <th>Nama</th>
                        <th width="120">Harga</th>
                        <th width="80">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produk as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>Rp {{ number_format($p->harga,0,',','.') }}</td>
                        <td>{{ $p->stok }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

{{-- ================= TREATMENT TERFAVORIT ================= --}}
<div class="card shadow-sm mb-3">
    <div class="card-body p-3">
        <h6 class="fw-bold mb-2">💆 5 Treatment Terfavorit</h6>

        @if($treatments->isEmpty())
            <div class="alert alert-info py-2 mb-0">Belum ada treatment.</div>
        @else
        <div class="table-responsive">
            <table class="table table-sm table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40">No</th>
                        <th>Nama</th>
                        <th width="120">Tipe</th>
                        <th width="120">Harga</th>
                        <th width="80">Durasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($treatments as $i => $t)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $t->nama_treatment }}</td>
                        <td>{{ $t->tipe }}</td>
                        <td>Rp {{ number_format($t->harga,0,',','.') }}</td>
                        <td>{{ $t->durasi }} mnt</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('pendapatanChart').getContext('2d');

// Gradient lebih halus
const gradient = ctx.createLinearGradient(0, 0, 0, 360);
gradient.addColorStop(0, 'rgba(54, 162, 235, 0.85)');
gradient.addColorStop(1, 'rgba(54, 162, 235, 0.25)');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($pendapatanLabels) !!},
        datasets: [{
            label: 'Pendapatan',
            data: {!! json_encode($pendapatanValues) !!},
            backgroundColor: gradient,
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            maxBarThickness: 45,
            categoryPercentage: 0.9,
            barPercentage: 0.9,
            hoverBackgroundColor: 'rgba(54, 162, 235, 1)',
            hoverBorderWidth: 2,
            borderRadius: 6
        }]
    },
    options: {
        maintainAspectRatio: false,
        animation: {
            duration: 1300,
            easing: 'easeOutQuart'
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let value = context.raw || 0;
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { maxRotation: 0, minRotation: 0 },
            },
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>

@endsection
