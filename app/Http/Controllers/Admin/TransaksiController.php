<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = DB::table('transactions')
            ->join('customer', 'transactions.customer_id', '=', 'customer.id')
            ->leftJoin('promos', 'transactions.promos_id', '=', 'promos.id')
            ->select(
                'transactions.*',
                'customer.nama_lengkap',
                'promos.nama_promo'
            )
            ->orderByDesc('transactions.tanggal_transaksi')
            ->get();

        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function create($konsultasi_id)
    {
        $konsultasi = DB::table('appointments_doctor')->where('id',$konsultasi_id)->first();
        abort_if(!$konsultasi,404);

        return view('admin.transaksi.create',[
            'konsultasi'=>$konsultasi,
            'customer'=>DB::table('customer')->where('id',$konsultasi->customer_id)->first(),
            'products'=>DB::table('products')->get(),
            'treatments'=>DB::table('treatments')->get(),
            'promos'=>DB::table('promos')->get(),
            'promoProducts'=>DB::table('promo_products')->get()->groupBy('promo_id'),
            'promoTreatments'=>DB::table('promo_treatments')->get()->groupBy('promo_id'),
        ]);
    }

   public function store(Request $request)
    {
        $request->validate([
            'customer_id'       => 'required',
            'metode_pembayaran' => 'required',
            'total'             => 'required|numeric'
        ]);

        DB::beginTransaction();

        try {
            $transaksiId = DB::table('transactions')->insertGetId([
                'customer_id'       => $request->customer_id,
                'admin_id'          => auth()->id() ?? 1,
                'promos_id'         => $request->promos_id,
                'metode_pembayaran' => $request->metode_pembayaran,
                'tanggal_transaksi' => now(),
                'total'             => $request->total
            ]);

            if ($request->filled('treatments')) {

                $reservasiServices = DB::table('reservasi_service')
                    ->join('services', 'reservasi_service.services_id', '=', 'services.id')
                    ->join('treatments', 'services.treatments_id', '=', 'treatments.id')
                    ->whereIn('treatments.id', $request->treatments)
                    ->where('reservasi_service.appointments_id', $request->konsultasi_id)
                    ->select(
                        'reservasi_service.id as reservasi_id',
                        'treatments.harga'
                    )
                    ->get();

                foreach ($reservasiServices as $item) {
                    DB::table('transactions_details')->insert([
                        'transactions_id'       => $transaksiId,
                        'pasien_id'             => $request->customer_id,
                        'reservasi_service_id'  => $item->reservasi_id,
                        'harga'                 => $item->harga
                    ]);
                }
            }


            if ($request->filled('products')) {

                $products = DB::table('products')
                    ->whereIn('id', $request->products)
                    ->get();

                foreach ($products as $product) {
                    DB::table('transactions_details')->insert([
                        'transactions_id'       => $transaksiId,
                        'pasien_id'             => $request->customer_id,
                        'reservasi_service_id'  => 0, 
                        'harga'                 => $product->harga
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.transaksi.index')
                ->with('success', 'Transaksi berhasil disimpan');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }


public function show($id)
{
    $transaksi = DB::table('transactions')
        ->leftJoin('promos', 'promos.id', '=', 'transactions.promos_id')
        ->select(
            'transactions.*',
            'promos.nama_promo',
            'promos.diskon_persen'
        )
        ->where('transactions.id', $id)
        ->first();

    $produk = DB::table('transactions_details as td')
        ->leftJoin('products as p', 'p.harga', '=', 'td.harga')
        ->select(
            'td.harga',
            DB::raw('MIN(p.nama) as nama_produk')
        )
        ->where('td.transactions_id', $id)
        ->where('td.reservasi_service_id', 0)
        ->groupBy('td.harga')
        ->get();

    $treatments = DB::table('transactions_details as td')
        ->join('treatments as t', 't.id', '=', 'td.reservasi_service_id')
        ->select(
            'td.harga',
            't.nama_treatment'
        )
        ->where('td.transactions_id', $id)
        ->where('td.reservasi_service_id', '!=', 0)
        ->get();

    return view('admin.transaksi.detail_transaksi', compact(
        'transaksi',
        'produk',
        'treatments'
    ));
}


}
