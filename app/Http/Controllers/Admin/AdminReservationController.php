<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppointmentsDoctor;

class AdminReservationController extends Controller
{
    
    public function index(Request $request)
    {
        $status = $request->get('status'); 

        $appointments = AppointmentsDoctor::with([
                'customer',
                'reservasiServices.service.treatment',
                'reservasiServices.terapis'
            ])
            ->when($status, function ($q) use ($status) {
                $q->whereHas('reservasiServices', function ($rs) use ($status) {
                    $rs->where('status', $status);
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reservasi.list_reservasi', compact('appointments', 'status'));
    }


    public function show($id)
    {
        $appointment = AppointmentsDoctor::with([
            'customer',
            'reservasiServices.service.treatment',
            'reservasiServices.terapis'
        ])->findOrFail($id);

        $currentStatus = optional(
            $appointment->reservasiServices->first()
        )->status;

        return view('admin.reservasi.detail_reservasi', compact(
            'appointment',
            'currentStatus'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:reserv,berjalan,selesai,batal treatment'
        ]);

        $appointment = AppointmentsDoctor::with('reservasiServices')->findOrFail($id);

        foreach ($appointment->reservasiServices as $rs) {
            $rs->update([
                'status' => $request->status
            ]);
        }

        return redirect()
            ->route('admin.reservasi.index')
            ->with('success', 'Status treatment berhasil diperbarui.');
    }
}
