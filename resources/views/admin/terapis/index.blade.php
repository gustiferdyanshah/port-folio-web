@extends('layouts.admin')
@section('title', 'Data Terapis')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Daftar Terapis</h4>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Terapis</th>
                        <th>Jenis Kelamin</th>
                        <th>No. WA</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($terapis as $index => $t)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $t->nama_terapis }}</td>
                        <td>{{ $t->jenis_kelamin }}</td>
                        <td>{{ $t->no_wa }}</td>
                        <td>
                            <span class="badge {{ $t->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($t->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="/admin/terapis/{{ $t->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $terapis->links() }}
        </div>
        <div class="mt-4">
            <a href="/admin/terapis/tambah" class="btn btn-success">+ Tambah Terapis Baru</a>
            <a href="/admin/dashboard" class="btn btn-secondary ms-2">&larr; Kembali ke Dashboard</a>
        </div>

    </div>
</div>
@endsection
