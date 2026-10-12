<?php

namespace App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use App\Models\Doctors;
use App\Models\Schedules;
use App\Models\Produk;


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

        if ($user && $credentials['password'] === $user->password) {
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
            'nama_lengkap'   => 'required',
            'email'          => 'required|email|unique:customer,email',
            'password'       => 'required|min:6',
            'birth_date'     => 'required|date',
            'jenis_kelamin'  => 'required|in:L,P',
            'alergi'         => 'nullable|string',
            'no_wa'          => 'required',
            'skin_types' => 'required|in:kering,berminyak',
        ]);

        Pelanggan::create([
            'nama_lengkap'   => $request->nama_lengkap,
            'email'          => $request->email,
            'password'       => $request->password, 
            'birth_date'     => $request->birth_date,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'alergi'         => $request->alergi,
            'no_wa'          => $request->no_wa,
            'skin_types'        => $request->skin_types,
            'users_id'       => 1,
        ]);

        return redirect('/pelanggan/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function dashboard()
    {
        /** @var Pelanggan $user */
        $user = auth('pelanggan')->user();

        $jadwal = $user->appointments()
            ->join('schedules', 'appointments_doctor.schedules_id', '=', 'schedules.id')
            ->join('doctors', 'schedules.doctors_id', '=', 'doctors.id')
            ->select(
                'appointments_doctor.id as appointment_id',
                'doctors.nama_dokter',
                'schedules.tanggal',
                'schedules.jam_mulai',
                'schedules.jam_selesai',
                'appointments_doctor.status'
            )
            ->get();

        $reservasi = $user->reservasi()->with('service.treatment', 'terapis')->get();
        $produk = Produk::latest()->take(6)->get(); 

        return view('dashboard.pelanggan', compact('user', 'jadwal', 'reservasi', 'produk'));

    }

    public function formKonsultasi()
    {
        $dokter = Doctors::select('id', 'nama_dokter')->get();
        $jadwal = Schedules::where('kuota', '>', 0)->get();

        return view('pelanggan.konsultasi_form', compact('dokter', 'jadwal'));
    }
}
