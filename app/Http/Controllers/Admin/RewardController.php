<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RewardController extends Controller
{
    public function index()
    {
        $items = DB::table('reward_items')->get();
        return view('admin.reward.index', compact('items'));
    }

    public function create()
    {
        return view('admin.reward.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_items' => 'required|string|max:45',
            'deskripsi' => 'nullable|string|max:255', 
            'stok' => 'required|integer|min:1',
            'poin_yang_dibutuhkan' => 'required|integer|min:1',
        ]);

        DB::table('reward_items')->insert([
            'nama_items' => $request->nama_items,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'poin_yang_dibutuhkan' => $request->poin_yang_dibutuhkan
        ]);

        return redirect('/admin/reward')->with('success', 'Reward berhasil ditambahkan.');
    }

}
