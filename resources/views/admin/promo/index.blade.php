@extends('layouts.admin')

@section('title', 'Kelola Promo')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Promo</h4>
        <a href="{{ route('admin.promos.create') }}" class="btn btn-primary btn-sm">
            + Tambah Promo
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Kode</th>
                    <th>Tipe</th>
                    <th>Diskon</th>
                    <th>Periode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promos as $promo)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td width="100">
                            @if($promo->gambar)
                                <img src="{{ asset($promo->gambar) }}"
                                     class="img-fluid"
                                     style="max-height:70px">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>{{ $promo->nama_promo }}</td>
                        <td>{{ $promo->kode_promo ?? '-' }}</td>
                        <td>{{ ucfirst($promo->tipe_promo) }}</td>
                        <td>
                            {{ $promo->tipe_promo === 'diskon'
                                ? $promo->diskon_persen.'%'
                                : '-' }}
                        </td>
                        <td>
                            {{ $promo->tanggal_mulai }} <br>
                            s/d {{ $promo->tanggal_selesai }}
                        </td>
                        <td>
                            <a href="{{ route('admin.promos.edit', $promo->id) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.promos.destroy', $promo->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus promo ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Belum ada promo
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $promos->links() }}
    </div>
</div>
@endsection
