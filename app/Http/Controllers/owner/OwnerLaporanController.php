<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerLaporanController extends Controller
{
    public function transaksi()
    {
        $transaksi = DB::table('transactions')
            ->orderByDesc('tanggal_transaksi')
            ->get();

        return view('owner.transaksi', compact('transaksi'));
    }

    public function pendapatan(Request $request)
    {
        $tanggalMulai = $request->query('tanggal_mulai');
        $tanggalAkhir = $request->query('tanggal_akhir');

        $query = DB::table('transactions')
            ->selectRaw('DATE(tanggal_transaksi) as tanggal, SUM(total) as total');

        if ($tanggalMulai && $tanggalAkhir) {
            $query->whereBetween(DB::raw('DATE(tanggal_transaksi)'), [
                $tanggalMulai,
                $tanggalAkhir
            ]);
        }

        $pendapatan = $query
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('owner.pendapatan', compact(
            'pendapatan',
            'tanggalMulai',
            'tanggalAkhir'
        ));
    }
}
