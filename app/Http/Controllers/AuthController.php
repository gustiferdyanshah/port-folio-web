<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showAdminLogin()
    {
        return view('auth.login_admin');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();
        if ($user && $credentials['password'] === $user->password) {

            if (in_array($user->role, ['admin', 'owner'])) {
                Auth::login($user);
                $request->session()->regenerate();

                return $user->role === 'admin'
                    ? redirect()->route('admin.dashboard')
                    : redirect()->route('owner.dashboard');
            }

            return back()->with('error', 'Akun ini bukan admin/owner.');
        }

        return back()->with('error', 'Email atau password salah.');
    }


    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,owner',
        ]);

        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => $request->password, 
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.login')->with('success', 'Registrasi berhasil.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
