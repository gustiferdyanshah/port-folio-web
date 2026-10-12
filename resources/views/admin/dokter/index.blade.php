@extends('layouts.admin')
@section('title', 'Data Dokter')

@section('content')
<h4 class="mb-3">Data Dokter</h4>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Dokter</th>
                <th style="width: 220px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dokter as $i => $d)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $d->nama_dokter }}</td>
                    <td>
                        {{-- Edit nama dokter --}}
                        <a href="/admin/dokter/{{ $d->id }}/edit"
                           class="btn btn-warning btn-sm">
                            Edit Nama
                        </a>

                        {{-- Edit akun login --}}
                        <a href="{{ route('admin.dokter.akun.edit', $d->id) }}"
                           class="btn btn-outline-secondary btn-sm ms-1">
                            Edit Akun
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<a href="/admin/dokter/tambah" class="btn btn-success mt-3">
    + Tambah Dokter Baru
</a>
@endsection
