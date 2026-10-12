@extends('layouts.admin')
@section('title', 'Daftar Jadwal Konsultasi')

@section('content')
<h2 class="mb-4">Daftar Jadwal Konsultasi</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($data->isEmpty())
    <div class="alert alert-info">Belum ada jadwal konsultasi.</div>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Pelanggan</th>
                    <th>Dokter</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $k)
                    <tr>
                        <td>{{ $k->nama_pelanggan ?? '-' }}</td>
                        <td>{{ $k->nama_dokter ?? '-' }}</td>
                        <td>{{ $k->tanggal ?? '-' }}</td>
                        <td>{{ $k->jam_mulai ?? '-' }} - {{ $k->jam_selesai ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ 
                                $k->status === 'pending' ? 'warning' : 
                                ($k->status === 'selesai' ? 'success' : 
                                ($k->status === 'batal' ? 'danger' : 'secondary')) }}">
                                {{ ucfirst($k->status) }}
                            </span>
                        </td>
                        <td>
                            @if($k->status === 'pending')
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalKonsultasi{{ $k->id }}">
                                    Isi Hasil
                                </button>
                            @else
                                <span class="text-muted">Sudah {{ ucfirst($k->status) }}</span>
                            @endif
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="modalKonsultasi{{ $k->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $k->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="/admin/konsultasi/{{ $k->id }}/isi">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel{{ $k->id }}">Isi Hasil Konsultasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Pelanggan:</strong> {{ $k->nama_pelanggan ?? '-' }}</p>
                                        <p><strong>Dokter:</strong> {{ $k->nama_dokter ?? '-' }}</p>
                                        <p><strong>Jadwal:</strong> {{ $k->tanggal ?? '-' }} {{ $k->jam_mulai ?? '-' }} - {{ $k->jam_selesai ?? '-' }}</p>

                                        <div class="mb-3">
                                            <label class="form-label">Catatan Hasil</label>
                                            <textarea name="hasil_konsultasi" class="form-control" rows="4" required>{{ old('hasil_konsultasi') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="">-- Pilih Status --</option>
                                                <option value="selesai">Selesai</option>
                                                <option value="batal">Batal</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Konsultasi Berikutnya (Opsional)</label>
                                            <input type="date" name="tanggal_berikutnya" class="form-control" value="{{ old('tanggal_berikutnya') }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
