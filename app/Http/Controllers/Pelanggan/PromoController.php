<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Promo;

class PromoController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $promos = Promo::whereDate('tanggal_mulai', '<=', $today)
                   ->whereDate('tanggal_selesai', '>=', $today)
                   ->paginate(3);

        return view('pelanggan.promo', compact('promos'));
    }
     public function show($id)
    {
        $promo = Promo::findOrFail($id);
        return view('pelanggan.promo_detail', compact('promo'));
    }
}
