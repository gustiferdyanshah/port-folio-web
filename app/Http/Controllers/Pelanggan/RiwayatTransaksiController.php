<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $customerId = auth()->id();
        $from = $request->from;
        $to   = $request->to;

        $transaksi = DB::table('transactions as t')
            ->leftJoin('transactions_details as td', 'td.transactions_id', '=', 't.id')
            ->leftJoin('appointments_doctor as ad', 'ad.customer_id', '=', 't.customer_id')
            ->leftJoin('reservasi_service as rs', 'rs.appointments_id', '=', 'ad.id')
            ->leftJoin('terapis as te', 'te.id', '=', 'rs.terapis_id')
            ->leftJoin('treatments as tr', function ($join) {
                $join->whereRaw("
                    ad.rekomendasi_treatments IS NOT NULL
                    AND FIND_IN_SET(tr.id, REPLACE(ad.rekomendasi_treatments, ' ', ''))
                ");
            })

            ->leftJoin('products as p', function ($join) {
                $join->whereRaw("
                    ad.rekomendasi_products IS NOT NULL
                    AND FIND_IN_SET(p.id, REPLACE(ad.rekomendasi_products, ' ', ''))
                ");
            })

            ->where('t.customer_id', $customerId)

            ->when($from, fn ($q) =>
                $q->whereDate('t.tanggal_transaksi', '>=', $from)
            )
            ->when($to, fn ($q) =>
                $q->whereDate('t.tanggal_transaksi', '<=', $to)
            )

            ->groupBy(
                't.id',
                't.tanggal_transaksi',
                't.metode_pembayaran',
                't.total'
            )

            ->select(
                't.id',
                't.tanggal_transaksi',
                't.metode_pembayaran',
                't.total',

                DB::raw("GROUP_CONCAT(DISTINCT tr.nama_treatment SEPARATOR ', ') as nama_treatment"),
                DB::raw("GROUP_CONCAT(DISTINCT p.nama SEPARATOR ', ') as nama_produk"),
                DB::raw("GROUP_CONCAT(DISTINCT te.nama_terapis SEPARATOR ', ') as nama_terapis"),
                DB::raw("GROUP_CONCAT(DISTINCT rs.tanggal_booking SEPARATOR ', ') as tanggal_booking"),
                DB::raw("SUM(td.harga) as subtotal")
            )

            ->orderByDesc('t.tanggal_transaksi')
            ->get();

        return view('pelanggan.riwayat_transaksi', compact('transaksi'));
    }
}
