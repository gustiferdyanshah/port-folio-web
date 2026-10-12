<?php

namespace App\Http\Controllers\Pelanggan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class KonsultasiController extends Controller
{
    public function riwayat()
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $jadwal = DB::table('appointments_doctor')
            ->join('schedules', 'appointments_doctor.schedules_id', '=', 'schedules.id')
            ->join('doctors', 'schedules.doctors_id', '=', 'doctors.id')
            ->where('appointments_doctor.customer_id', $pelanggan->id)
            ->select(
                'appointments_doctor.id as appointment_id',
                'doctors.nama_dokter',
                'schedules.tanggal',
                'schedules.jam_mulai',
                'schedules.jam_selesai',
                'appointments_doctor.status'
            )
            ->orderBy('schedules.tanggal', 'desc')
            ->get();

        return view('dashboard.pelanggan', [
            'user' => $pelanggan,
            'jadwal' => $jadwal
        ]);
    }

    public function form()
    {
        $dokter = DB::table('doctors')
            ->whereIn('id', function ($query) {
                $query->select('doctors_id')
                    ->from('schedules')
                    ->where('kuota', '>', 0)
                    ->whereDate('tanggal', '>=', date('Y-m-d'));
            })
            ->get();

        $jadwal = DB::table('schedules')
            ->where('kuota', '>', 0)
            ->whereDate('tanggal', '>=', date('Y-m-d'))
            ->get();

        return view('pelanggan.konsultasi_form', compact('dokter', 'jadwal'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $pelangganId = Auth::guard('pelanggan')->id();
        $cekAktif = DB::table('appointments_doctor')
            ->where('customer_id', $pelangganId)
            ->whereIn('status', ['pending', 'dikonfirmasi'])
            ->exists();

        if ($cekAktif) {
            return back()->with('warning',
                'Maaf, Anda masih memiliki jadwal konsultasi yang aktif. Silakan selesaikan terlebih dahulu sebelum membuat jadwal baru.'
            );
        }

        $jadwal = DB::table('schedules')->where('id', $request->schedule_id)->first();

        if (!$jadwal || $jadwal->kuota < 1) {
            return back()->with('error', 'Slot sudah penuh atau tidak tersedia.');
        }

        DB::table('appointments_doctor')->insert([
            'customer_id' => $pelangganId,
            'schedules_id' => $request->schedule_id,
            'status' => 'pending'
        ]);

        DB::table('schedules')
            ->where('id', $request->schedule_id)
            ->decrement('kuota');

        return redirect('/pelanggan/dashboard')
            ->with('success', 'Jadwal berhasil dibuat.');
    }


    public function batal($id)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $jadwal = DB::table('appointments_doctor')
            ->where('id', $id)
            ->where('customer_id', $pelanggan->id)
            ->first();

        if (!$jadwal) {
            return redirect('/pelanggan/dashboard')->with('error', 'Jadwal tidak ditemukan.');
        }

        $schedule = DB::table('schedules')->where('id', $jadwal->schedules_id)->first();

        if ($schedule && $schedule->tanggal > date('Y-m-d')) {
            DB::table('appointments_doctor')->where('id', $id)->delete();
            DB::table('schedules')->where('id', $schedule->id)->increment('kuota');

            return redirect('/pelanggan/dashboard')->with('success', 'Jadwal berhasil dibatalkan.');
        }

        return redirect('/pelanggan/dashboard')->with('error', 'Tidak bisa membatalkan jadwal yang sudah lewat.');
    }

    public function edit($id)
    {
        $pelanggan_id = Auth::guard('pelanggan')->id();

        $appointment = DB::table('appointments_doctor')
            ->where('id', $id)
            ->where('customer_id', $pelanggan_id)
            ->first();

        if (!$appointment) {
            return redirect('/pelanggan/dashboard')->with('error', 'Jadwal tidak ditemukan.');
        }

        $current_schedule = DB::table('schedules')->where('id', $appointment->schedules_id)->first();

        if ($current_schedule->tanggal <= date('Y-m-d')) {
            return redirect('/pelanggan/dashboard')->with('error', 'Jadwal yang sudah lewat tidak bisa diubah.');
        }

        $schedules = DB::table('schedules')
            ->where('doctors_id', $current_schedule->doctors_id)
            ->where('kuota', '>', 0)
            ->where('tanggal', '>', date('Y-m-d'))
            ->get();

        return view('pelanggan.edit_jadwal', compact('appointment', 'current_schedule', 'schedules'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id'
        ]);

        $pelanggan = Auth::guard('pelanggan')->user();

        $appointment = DB::table('appointments_doctor')
            ->where('id', $id)
            ->where('customer_id', $pelanggan->id)
            ->first();

        if (!$appointment) {
            return redirect('/pelanggan/dashboard')->with('error', 'Data jadwal tidak ditemukan.');
        }

        $old_schedule = DB::table('schedules')->where('id', $appointment->schedules_id)->first();
        $new_schedule = DB::table('schedules')->where('id', $request->schedule_id)->first();

        if ($old_schedule->tanggal <= date('Y-m-d')) {
            return redirect('/pelanggan/dashboard')->with('error', 'Jadwal yang sudah lewat tidak bisa diubah.');
        }

        DB::table('appointments_doctor')
            ->where('id', $id)
            ->update(['schedules_id' => $request->schedule_id]);

        DB::table('schedules')->where('id', $old_schedule->id)->increment('kuota');
        DB::table('schedules')->where('id', $new_schedule->id)->decrement('kuota');

        return redirect('/pelanggan/dashboard')->with('success', 'Jadwal berhasil diubah.');
    }
}
