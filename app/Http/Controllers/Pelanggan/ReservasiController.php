<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Services;
use App\Models\Terapis;
use App\Models\ReservasiService;
use Illuminate\Support\Facades\Mail;
use App\Jobs\KirimEmailReservasi;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasi = ReservasiService::whereHas('service.appointment', function ($q) {
            $q->where('customer_id', Auth::guard('pelanggan')->id());
        })
        ->with(['service.treatment', 'terapis'])
        ->orderBy('tanggal_booking', 'desc')
        ->get();

        return view('pelanggan.reservasi.index', compact('reservasi'));
    }

    public function create()
    {
        $customerId = Auth::guard('pelanggan')->id();
        $aktif = ReservasiService::whereHas('service.appointment', function($q) use ($customerId) {
                $q->where('customer_id', $customerId);
            })
            ->whereIn('status', ['reserv', 'berjalan'])
            ->first();

        if ($aktif) {
            return redirect()->route('pelanggan.reservasi.aktif');
        }
        $service = Services::whereHas('appointment', function ($q) use ($customerId) {
                $q->where('customer_id', $customerId)
                ->where('status', 'selesai');
            })
            ->with(['treatment', 'appointment'])
            ->orderBy('id', 'desc')
            ->first();

        if (!$service) {
            return redirect()->back()
                ->with('error', 'Belum ada hasil konsultasi dokter.');
        }

        $terapis = Terapis::where('status', 'aktif')->get();

        return view('pelanggan.form_reservasi', compact(
            'service',
            'terapis'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_booking' => 'required|date',
            'jam_booking'     => 'required',
            'jam_selesai'     => 'required',
            'terapis_id'      => 'required'
        ]);

        $reservasi = ReservasiService::create([
            'appointments_id' => $request->appointments_id,
            'services_id'     => $request->services_id,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_booking'     => $request->jam_booking,
            'jam_ending'      => $request->jam_selesai,
            'terapis_id'      => $request->terapis_id,
            'status'          => 'reserv'
        ]);

        return redirect()
            ->route('pelanggan.reservasi.detail', $reservasi->id)
            ->with('success', 'Reservasi berhasil dibuat.');
    }

    public function detail($id)
    {
        $reservasi = ReservasiService::with([
            'service.appointment',
            'service.treatment',
            'terapis'
        ])->findOrFail($id);

        return view('pelanggan.detail_reservasi', compact('reservasi'));
    }

   public function konfirmasiStore($id)
    {
        $reservasi = ReservasiService::findOrFail($id);

        $reservasi->status = 'berjalan';
        $reservasi->save();
        KirimEmailReservasi::dispatch($reservasi);

        return redirect()->route('pelanggan.dashboard')
                        ->with('success', 'Reservasi berhasil dikonfirmasi. Email dikirim via Mailtrap.');
    }

}
