<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;
use Carbon\Carbon;

class DokterController extends Controller
{
    public function dashboard(Request $request)
    {
        $dokterId = Auth::guard('doctor')->id();
        $keyword = $request->keyword;
        $pasien = null;

        if (!empty($keyword)) {
            $pasien = DB::table('customer')
                ->where('nama_lengkap', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->orWhere('no_wa', 'like', "%{$keyword}%")
                ->first();
        }
        $konsultasi = DB::table('appointments_doctor as a')
            ->join('schedules as s', 's.id', '=', 'a.schedules_id')
            ->join('customer as c', 'c.id', '=', 'a.customer_id')
            ->where('s.doctors_id', $dokterId)
            ->whereIn('a.status', ['pending', 'dikonfirmasi'])
            ->select(
                'a.id',
                'a.status',
                's.tanggal as tanggal_konsultasi',
                'c.nama_lengkap'
            )
            ->orderBy('s.tanggal', 'asc')
            ->paginate(5);

        return view('dashboard.dokter', compact(
            'konsultasi',
            'keyword',
            'pasien'
        ));
    }

    public function jadwalKonsultasi(Request $request)
    {
        $doctorId = Auth::guard('doctor')->id();

        $query = DB::table('appointments_doctor as a')
            ->join('schedules as s', 'a.schedules_id', '=', 's.id')
            ->join('customer as c', 'a.customer_id', '=', 'c.id')
            ->where('s.doctors_id', $doctorId)
            ->select(
                'a.id',
                'a.status',
                'c.nama_lengkap',
                'c.jenis_kelamin',
                'c.skin_types',
                's.tanggal',
                's.jam_mulai',
                's.jam_selesai'
            );

        if ($request->filter === 'today') {
            $query->whereDate('s.tanggal', Carbon::today());
        } elseif ($request->filter === 'week') {
            $query->whereBetween('s.tanggal', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        }

        $appointments = $query->orderBy('s.tanggal')->paginate(10);

        $todayCount = DB::table('appointments_doctor as a')
            ->join('schedules as s', 'a.schedules_id', '=', 's.id')
            ->where('s.doctors_id', $doctorId)
            ->whereDate('s.tanggal', Carbon::today())
            ->count();

        return view('dokter.jadwal_konsultasi', compact('appointments', 'todayCount'));
    }

    public function detailKonsultasi($id)
    {
        $data = DB::table('appointments_doctor as a')
            ->join('customer as c', 'a.customer_id', '=', 'c.id')
            ->select(
                'a.id',
                'a.status',
                'a.hasil_konsultasi',
                'a.rekomendasi_products',
                'a.rekomendasi_treatments',
                'c.nama_lengkap',
                'c.jenis_kelamin',
                'c.skin_types'
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

        return view('dokter.detail_konsultasi', compact(
            'data',
            'products',
            'treatments'
        ));
    }

    public function simpanHasilKonsultasi(Request $request, $id)
    {
        $request->validate([
            'skin_types'        => 'required|in:kering,berminyak,normal,sensitif,kombinasi',
            'status'            => 'required|in:selesai,batal',
            'hasil_konsultasi'  => 'nullable|string',
            'products'          => 'nullable|array',
            'products.*'        => 'integer|exists:products,id',
            'treatments'        => 'nullable|array',
            'treatments.*'      => 'integer|exists:treatments,id',
        ]);

        $appointment = DB::table('appointments_doctor')->where('id', $id)->first();
        abort_if(!$appointment, 404);

        DB::table('customer')
            ->where('id', $appointment->customer_id)
            ->update(['skin_types' => $request->skin_types]);

        DB::table('appointments_doctor')
            ->where('id', $id)
            ->update([
                'status' => $request->status,
                'hasil_konsultasi' => $request->hasil_konsultasi,
                'rekomendasi_products' => $request->products
                    ? implode(',', $request->products)
                    : null,
                'rekomendasi_treatments' => $request->treatments
                    ? implode(',', $request->treatments)
                    : null,
                'updated_at' => now()
            ]);

        return redirect()
            ->route('dokter.jadwal.konsultasi')
            ->with('success', 'Hasil konsultasi berhasil disimpan');
    }
}
