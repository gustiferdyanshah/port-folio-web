@extends('layouts.dokter')

@section('title', 'Jadwal Konsultasi')

@section('content')
<h3 class="mb-3">
    🗓️ Jadwal Konsultasi Pasien
    <span class="badge bg-success ms-2">
        Hari ini: {{ $todayCount }}
    </span>
</h3>

{{-- FILTER --}}
<div class="mb-3">
    <a href="{{ route('dokter.jadwal.konsultasi', ['filter' => 'today']) }}"
       class="btn btn-outline-primary btn-sm">
        Hari Ini
    </a>
    <a href="{{ route('dokter.jadwal.konsultasi', ['filter' => 'week']) }}"
       class="btn btn-outline-secondary btn-sm">
        Minggu Ini
    </a>
    <a href="{{ route('dokter.jadwal.konsultasi') }}"
       class="btn btn-outline-dark btn-sm">
        Semua
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Jenis Kelamin</th>
                    <th>Tipe Kulit</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($appointments as $index => $a)
                    <tr>
                        <td class="text-center">
                            {{ $appointments->firstItem() + $index }}
                        </td>
                        <td>{{ $a->nama_lengkap }}</td>
                        <td class="text-center">{{ $a->jenis_kelamin }}</td>
                        <td class="text-center">{{ ucfirst($a->skin_types) }}</td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}
                        </td>
                        <td class="text-center">
                            {{ $a->jam_mulai }} - {{ $a->jam_selesai }}
                        </td>
                        <td class="text-center">
                            @php
                                $badge = match($a->status) {
                                    'pending' => 'warning',
                                    'dikonfirmasi' => 'info',
                                    'selesai' => 'success',
                                    'batal' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp

                            <span class="badge bg-{{ $badge }}">
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('dokter.konsultasi.detail', $a->id) }}"
                               class="btn btn-sm btn-primary">
                                Konsultasi
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Tidak ada jadwal konsultasi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="mt-3">
            {{ $appointments->links() }}
        </div>

    </div>
</div>
@endsection
