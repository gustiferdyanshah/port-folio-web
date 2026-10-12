<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerMonitoringController extends Controller
{
    public function operasional(Request $request)
    {
        $startDate = $request->query('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->query('end_date', Carbon::today()->format('Y-m-d'));
        $totalReservasi = DB::table('reservasi_service')
            ->whereBetween('tanggal_booking', [$startDate, $endDate])
            ->count();

        $reservasiBerjalan = DB::table('reservasi_service')
            ->whereBetween('tanggal_booking', [$startDate, $endDate])
            ->where('status', 'berjalan')
            ->count();

        $reservasiSelesai = DB::table('reservasi_service')
            ->whereBetween('tanggal_booking', [$startDate, $endDate])
            ->where('status', 'selesai')
            ->count();

        $reservasiBatal = DB::table('reservasi_service')
            ->whereBetween('tanggal_booking', [$startDate, $endDate])
            ->where('status', 'batal treatment')
            ->count();

        $jadwalTerapi = DB::table('reservasi_service')
            ->join('terapis', 'terapis.id', '=', 'reservasi_service.terapis_id')
            ->join('services', 'services.id', '=', 'reservasi_service.services_id')
            ->join('treatments', 'treatments.id', '=', 'services.treatments_id')
            ->select(
                'terapis.nama_terapis as terapis_nama',
                'reservasi_service.tanggal_booking',
                'reservasi_service.jam_booking',
                'reservasi_service.jam_ending',
                'treatments.nama_treatment'
            )
            ->whereBetween('reservasi_service.tanggal_booking', [$startDate, $endDate])
            ->orderBy('reservasi_service.tanggal_booking')
            ->orderBy('reservasi_service.jam_booking')
            ->get();

        return view('owner.operasional', compact(
            'totalReservasi',
            'reservasiBerjalan',
            'reservasiSelesai',
            'reservasiBatal',
            'jadwalTerapi',
            'startDate',
            'endDate'
        ));
    }
}
