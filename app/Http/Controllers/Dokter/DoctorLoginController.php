<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctors; 

class DoctorLoginController extends Controller
{
    
    public function showLoginForm()
    {
        return view('auth.login_dokter'); 
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);
        $doctor = Doctors::where('email', $request->email)->first();

        if ($doctor && $doctor->password === $request->password) {
            Auth::guard('doctor')->login($doctor);
            $request->session()->regenerate();
            return redirect()->route('dokter.dashboard')
                ->with('success', 'Berhasil login sebagai dokter');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('doctor')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dokter.login')
            ->with('success', 'Berhasil logout.');
    }
}
