<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->paginate(6);
        return view('admin.promo.index', compact('promos'));
    }

    public function create()
    {
        $products   = DB::table('products')->get();
        $treatments = DB::table('treatments')->get();

        return view('admin.promo.create', compact('products', 'treatments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_promo'      => 'required|max:45',
            'kode_promo'      => 'nullable|max:50',
            'tipe_promo'      => 'required|in:diskon,bundling',
            'diskon_persen'   => 'nullable|integer|min:1|max:100',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'deskripsi'       => 'nullable',
            'gambar'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'products'        => 'nullable|array',
            'treatments'      => 'nullable|array',
        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('promo'), $filename);
            $gambarPath = 'promo/'.$filename;
        }

        $promo = Promo::create([
            'nama_promo'      => $request->nama_promo,
            'kode_promo'      => $request->kode_promo,
            'tipe_promo'      => $request->tipe_promo,
            'diskon_persen'   => $request->diskon_persen,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'deskripsi'       => $request->deskripsi,
            'gambar'          => $gambarPath,
        ]);

        $promo->products()->sync($request->products ?? []);
        $promo->treatments()->sync($request->treatments ?? []);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil ditambahkan');
    }

    public function edit(Promo $promo)
    {
        $products   = DB::table('products')->get();
        $treatments = DB::table('treatments')->get();

        return view('admin.promo.edit', compact(
            'promo',
            'products',
            'treatments'
        ));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'nama_promo'      => 'required|max:45',
            'kode_promo'      => 'nullable|max:50',
            'tipe_promo'      => 'required|in:diskon,bundling',
            'diskon_persen'   => 'nullable|integer|min:1|max:100',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'deskripsi'       => 'nullable',
            'gambar'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = $promo->gambar;

        if ($request->hasFile('gambar')) {
            if ($gambarPath && file_exists(public_path($gambarPath))) {
                unlink(public_path($gambarPath));
            }

            $file = $request->file('gambar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('promo'), $filename);
            $gambarPath = 'promo/'.$filename;
        }

        $promo->update([
            'nama_promo'      => $request->nama_promo,
            'kode_promo'      => $request->kode_promo,
            'tipe_promo'      => $request->tipe_promo,
            'diskon_persen'   => $request->diskon_persen,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'deskripsi'       => $request->deskripsi,
            'gambar'          => $gambarPath,
        ]);

        $promo->products()->sync($request->products ?? []);
        $promo->treatments()->sync($request->treatments ?? []);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil diperbarui');
    }

    public function destroy(Promo $promo)
    {
        if ($promo->gambar && file_exists(public_path($promo->gambar))) {
            unlink(public_path($promo->gambar));
        }

        $promo->delete();

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil dihapus');
    }
}
