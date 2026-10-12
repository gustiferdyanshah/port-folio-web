@extends('layouts.owner')

@section('title', 'Analisis Penjualan')

@section('content')

<h4 class="mb-3">📊 Analisis Penjualan</h4>

<form method="GET" class="mb-4 d-flex gap-3 align-items-center flex-wrap">
    <label for="start_date" class="form-label mb-0">Dari:</label>
    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="form-control form-control-sm" />

    <label for="end_date" class="form-label mb-0">Sampai:</label>
    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="form-control form-control-sm" />

    <label class="form-check-label">
        <input type="checkbox" name="exclude_unknown" value="1" class="form-check-input" {{ $excludeUnknown ? 'checked' : '' }}>
        Exclude Unknown Treatment
    </label>

    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
</form>

@if($unknownCount > 0 && !$excludeUnknown)
    <p class="text-warning">⚠️ Ada {{ $unknownCount }} transaksi dengan data treatment tidak valid (Unknown Treatment).</p>
@endif

@if($data->isEmpty())
    <p class="text-muted">Tidak ada data penjualan di periode tersebut.</p>
@else

<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>Produk / Treatment</th>
            <th>Total Qty Terjual</th>
            <th>Total Pendapatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr @if($item->nama_produk === 'Unknown Treatment') class="table-warning" @endif>
                <td>
                    @if($item->nama_produk === 'Unknown Treatment')
                        <strong>{{ $item->nama_produk }}</strong>
                    @else
                        {{ $item->nama_produk }}
                    @endif
                </td>
                <td>{{ $item->total_qty }}</td>
                <td>Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endif

@endsection
