<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KonsultasiAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('appointments_doctor as a')
            ->join('customer as c', 'a.customer_id', '=', 'c.id')
            ->join('schedules as s', 'a.schedules_id', '=', 's.id')
            ->join('doctors as d', 's.doctors_id', '=', 'd.id')
            ->select(
                'a.id',
                'a.status',
                'c.nama_lengkap as nama_pelanggan',
                'd.nama_dokter',
                's.tanggal',
                's.jam_mulai',
                's.jam_selesai'
            );

        if ($request->filled('dokter')) {
            $query->where('d.id', $request->dokter);
        }

        if ($request->filled('status')) {
            $query->where('a.status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('s.tanggal', $request->tanggal);
        }

        $query->orderBy('s.tanggal', $request->sort === 'tanggal_desc' ? 'desc' : 'asc');

        $data = $query->paginate(10);
        $dokters = DB::table('doctors')->get();

        return view('admin.jadwal.index', compact('data', 'dokters'));
    }

    public function detail($id)
    {
        $data = DB::table('appointments_doctor as a')
            ->join('customer as c', 'a.customer_id', '=', 'c.id')
            ->join('schedules as s', 'a.schedules_id', '=', 's.id')
            ->join('doctors as d', 's.doctors_id', '=', 'd.id')
            ->select(
                'a.id',
                'a.status',
                'a.hasil_konsultasi',
                'a.rekomendasi_products',
                'a.rekomendasi_treatments',
                'c.nama_lengkap as pasien',
                'c.skin_types',
                'd.nama_dokter as dokter',
                's.tanggal as tanggal_konsultasi',
                's.jam_mulai',
                's.jam_selesai'
            )
            ->where('a.id', $id)
            ->first();

        abort_if(!$data, 404);

        $products = DB::table('products')
            ->select('id', 'nama')
            ->orderBy('nama')
            ->get();

        $treatments = DB::table('treatments')
            ->select('id', 'nama_treatment')
            ->orderBy('nama_treatment')
            ->get();

        return view('admin.jadwal.detail', compact(
            'data',
            'products',
            'treatments'
        ));
    }

    public function ajukan(Request $request, $id)
    {
        DB::table('appointments_doctor')
            ->where('id', $id)
            ->update([
                'rekomendasi_products' => $request->products
                    ? implode(',', $request->products)
                    : null,

                'rekomendasi_treatments' => $request->treatments
                    ? implode(',', $request->treatments)
                    : null,

                'status' => 'selesai',
                'updated_at' => now()
            ]);
        return redirect()->route('admin.transaksi.create', $id);
    }

    public function batal($id)
    {
        DB::table('appointments_doctor')
            ->where('id', $id)
            ->update([
                'status' => 'batal',
                'updated_at' => now()
            ]);

        return redirect()
            ->route('admin.konsultasi')
            ->with('success', 'Konsultasi dibatalkan');
    }
}
