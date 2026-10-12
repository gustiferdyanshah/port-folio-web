<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TreatmentController extends Controller
{
    public function index()
    {
        $treatments = DB::table('treatments')
            ->join('treatment_types', 'treatments.treatment_types_id', '=', 'treatment_types.id')
            ->select(
                'treatments.*',
                'treatment_types.nama as nama_tipe'
            )
            ->latest('treatments.created_at')
            ->paginate(10);

        return view('admin.treatment.index', compact('treatments'));
    }

    public function create()
    {
        $treatmentTypes = DB::table('treatment_types')->get();
        return view('admin.treatment.form_tambah', compact('treatmentTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_treatment' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'treatment_types_id' => 'required|exists:treatment_types,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('treatment'), $filename);
            $gambarPath = 'treatment/'.$filename;
        }

        DB::table('treatments')->insert([
            'nama_treatment' => $request->nama_treatment,
            'harga' => $request->harga,
            'durasi' => $request->durasi,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
            'treatment_types_id' => $request->treatment_types_id,
        ]);

        return redirect()
            ->route('admin.treatment.index')
            ->with('success', 'Treatment berhasil ditambahkan');
    }

    public function edit($id)
    {
        $treatment = DB::table('treatments')->where('id', $id)->first();
        $treatmentTypes = DB::table('treatment_types')->get();

        if (!$treatment) {
            return redirect()
                ->route('admin.treatment.index')
                ->with('error', 'Treatment tidak ditemukan');
        }

        return view('admin.treatment.form_edit', compact('treatment', 'treatmentTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_treatment' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'treatment_types_id' => 'required|exists:treatment_types,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $treatment = DB::table('treatments')->where('id', $id)->first();
        $gambarPath = $treatment->gambar;

        if ($request->hasFile('gambar')) {

            if ($gambarPath && file_exists(public_path($gambarPath))) {
                unlink(public_path($gambarPath));
            }

            $file = $request->file('gambar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('treatment'), $filename);
            $gambarPath = 'treatment/'.$filename;
        }

        DB::table('treatments')->where('id', $id)->update([
            'nama_treatment' => $request->nama_treatment,
            'harga' => $request->harga,
            'durasi' => $request->durasi,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
            'treatment_types_id' => $request->treatment_types_id,
        ]);

        return redirect()
            ->route('admin.treatment.index')
            ->with('success', 'Treatment berhasil diperbarui');
    }

    public function destroy($id)
    {
        $treatment = DB::table('treatments')->where('id', $id)->first();

        if ($treatment && $treatment->gambar && file_exists(public_path($treatment->gambar))) {
            unlink(public_path($treatment->gambar));
        }

        DB::table('treatments')->where('id', $id)->delete();

        return redirect()
            ->route('admin.treatment.index')
            ->with('success', 'Treatment berhasil dihapus');
    }
}
