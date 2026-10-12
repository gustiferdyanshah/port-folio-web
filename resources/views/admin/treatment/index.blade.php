@extends('layouts.admin')
@section('title', 'Manajemen Treatment')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <h4 class="mb-0">Daftar Treatment</h4>
        <a href="{{ route('admin.treatment.create') }}" class="btn btn-light btn-sm">
            + Tambah Treatment
        </a>
    </div>

    <div class="card-body">
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
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($treatments as $t)
                        <tr>
                            <td>{{ $loop->iteration + ($treatments->currentPage()-1) * $treatments->perPage() }}</td>

                            <td width="100">
                                @if($t->gambar)
                                    <img src="{{ asset($t->gambar) }}" class="img-fluid" style="max-height:70px">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>{{ $t->nama_treatment }}</td>
                            <td>{{ $t->nama_tipe }}</td>
                            <td>Rp{{ number_format($t->harga,0,',','.') }}</td>
                            <td>{{ $t->durasi }} menit</td>

                            <td>
                                <a href="{{ route('admin.treatment.edit',$t->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.treatment.destroy',$t->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Belum ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $treatments->links() }}
        </div>
    </div>
</div>
@endsection
