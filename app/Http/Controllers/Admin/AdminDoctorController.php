<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctors;
use Illuminate\Http\Request;

class AdminDoctorController extends Controller
{
    public function create()
    {
        $doctors = Doctors::select('id', 'nama_dokter')->get();
        return view('admin.dokter.register', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|unique:doctors,email',
            'password' => 'required|min:6|confirmed',
        ]);

        Doctors::create([
            'email'    => $request->email,
            'password' => $request->password, 
        ]);

        return redirect('/admin/dokter')
            ->with('success', 'Akun dokter berhasil dibuat');
    }

    public function editAkun($id)
    {
        $doctor = Doctors::findOrFail($id);
        return view('admin.dokter.edit_akun', compact('doctor'));
    }

    public function updateAkun(Request $request, $id)
    {
        $doctor = Doctors::findOrFail($id);

        $request->validate([
            'email'    => 'required|email|unique:doctors,email,' . $doctor->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $doctor->email = $request->email;

        if ($request->filled('password')) {
            $doctor->password = $request->password; 
        }

        $doctor->save();

        return redirect('/admin/dokter')
            ->with('success', 'Akun dokter berhasil diperbarui');
    }
}
