<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;

class PelangganLoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login_pelanggan');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = Pelanggan::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::guard('pelanggan')->login($user);
            $request->session()->regenerate();

            return redirect('/pelanggan/dashboard');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/pelanggan/login');
    }

    public function showRegister()
    {
        return view('auth.register_pelanggan');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:customer,email',
            'password' => 'required|min:6',
            'birth_date' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alergi' => 'nullable|string',
            'no_wa' => 'required',
            'skin_types_id' => 'required|exists:skin_types,id',
        ]);

        Pelanggan::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birth_date' => $request->birth_date,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alergi' => $request->alergi,
            'no_wa' => $request->no_wa,
            'skin_types_id' => $request->skin_types_id,
            'users_id' => 1
        ]);

        return redirect('/pelanggan/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function dashboard()
    {
        /** @var \App\Models\Pelanggan $user */
        $user = auth('pelanggan')->user();

        $jadwal = $user->appointments()
            ->join('schedules', 'appointments_doctor.schedules_id', '=', 'schedules.id')
            ->join('doctors', 'schedules.doctors_id', '=', 'doctors.id')
            ->select('appointments_doctor.id as appointment_id', 'doctors.nama_dokter', 'schedules.tanggal', 'schedules.jam')
            ->get();

        $reservasi = $user->reservasi()->with('service.treatment', 'terapis')->get();

        return view('pelanggan.dashboard', compact('user', 'jadwal', 'reservasi'));
    }
}
