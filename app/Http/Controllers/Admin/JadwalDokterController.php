<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalDokterController extends Controller
{
    public function index()
    {
        $jadwals = DB::table('schedules as s')
            ->join('doctors as d', 's.doctors_id', '=', 'd.id')
            ->select(
                's.id',
                'd.nama_dokter',
                's.tanggal',
                's.jam_mulai',
                's.jam_selesai',
                's.kuota'
            )
            ->orderBy('d.nama_dokter')
            ->orderBy('s.tanggal')
            ->paginate(5);
        
        $doctors = DB::table('doctors')->get();

        return view('admin.dokter.jadwal_dokter', compact(
            'jadwals',
            'doctors'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctors_id' => 'required',
            'tanggal'    => 'required|date',
            'jam_mulai'  => 'required',
            'jam_selesai'=> 'required',
            'kuota'      => 'required|numeric|min:1'
        ]);

        DB::table('schedules')->insert([
            'doctors_id' => $request->doctors_id,
            'tanggal'    => $request->tanggal,
            'jam_mulai'  => $request->jam_mulai,
            'jam_selesai'=> $request->jam_selesai,
            'kuota'      => $request->kuota
        ]);

        return redirect()
            ->route('admin.dokter.jadwal')
            ->with('success', 'Jadwal dokter berhasil ditambahkan');
    }
}
