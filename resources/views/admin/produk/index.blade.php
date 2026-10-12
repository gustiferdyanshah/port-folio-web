@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Kelola Produk</h2>
        <button class="btn btn-success" data-bs-toggle="collapse" data-bs-target="#formTambah">
            + Tambah Produk
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- FORM TAMBAH -->
    <div id="formTambah" class="collapse mb-4">
        <div class="card card-body">
            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" min="0" value="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <button class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <!-- TABEL -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produks as $produk)
                    <tr>
                        <td>{{ $loop->iteration + ($produks->currentPage()-1) * $produks->perPage() }}</td>

                        <td width="100">
                            @if($produk->image)
                                <img src="{{ asset($produk->image) }}" class="img-fluid" style="max-height:70px">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>{{ $produk->nama }}</td>
                        <td>Rp{{ number_format($produk->harga,0,',','.') }}</td>

                        <td>
                            <span class="badge {{ $produk->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $produk->stok }}
                            </span>
                        </td>

                        <td>{{ \Illuminate\Support\Str::limit($produk->deskripsi, 60) }}</td>

                        <td>
                            <a href="{{ route('admin.produk.edit',$produk->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <form action="{{ route('admin.produk.destroy',$produk->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada produk</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $produks->links() }}
    </div>
</div>
@endsection
