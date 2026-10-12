@extends('layouts.dokter')

@section('content')
<div class="container">
    <h1>Dashboard Dokter</h1>

    <form action="{{ route('dokter.dashboard') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Cari pasien..."
                value="{{ $keyword }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    @if($pelanggan->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelanggan as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->email }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning">
            Tidak ada pasien ditemukan @if($keyword) dengan nama <b>{{ $keyword }}</b> @endif.
        </div>
    @endif
</div>
@endsection
