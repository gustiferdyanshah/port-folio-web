<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $pelangganAktif = DB::table('customer')->count();

        $promoAktif = DB::table('promos')
            ->whereDate('tanggal_mulai', '<=', now())
            ->whereDate('tanggal_selesai', '>=', now())
            ->count();
        $produk = DB::table('products')
            ->join('transactions_details', 'products.id', '=', 'transactions_details.reservasi_service_id')
            ->select('products.nama', 'products.harga', 'products.stok', DB::raw('COUNT(transactions_details.id) as total_order'))
            ->groupBy('products.id', 'products.nama', 'products.harga', 'products.stok')
            ->orderByDesc('total_order')
            ->limit(5)
            ->get();

        $treatments = DB::table('treatments')
            ->join('transactions_details', 'treatments.id', '=', 'transactions_details.reservasi_service_id')
            ->join('treatment_types', 'treatments.treatment_types_id', '=', 'treatment_types.id')
            ->select(
                'treatments.nama_treatment',
                'treatment_types.nama as tipe',
                'treatments.harga',
                'treatments.durasi',
                DB::raw('COUNT(transactions_details.id) as total_order')
            )
            ->groupBy('treatments.id', 'treatments.nama_treatment', 'treatment_types.nama', 'treatments.harga', 'treatments.durasi')
            ->orderByDesc('total_order')
            ->limit(5)
            ->get();
        $filter = $request->query('filter', 'monthly'); 
        $pendapatanLabels = [];
        $pendapatanValues = [];
        $query = DB::table('transactions');

        switch ($filter) {
            case 'daily':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                $data = $query->selectRaw('DATE(tanggal_transaksi) as date, SUM(total) as total')
                    ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                foreach ($data as $row) {
                    $pendapatanLabels[] = Carbon::parse($row->date)->format('d M');
                    $pendapatanValues[] = $row->total;
                }
                break;

            case 'weekly':
                $data = $query->selectRaw('YEARWEEK(tanggal_transaksi,1) as week, SUM(total) as total')
                    ->whereYear('tanggal_transaksi', Carbon::now()->year)
                    ->groupBy('week')
                    ->orderBy('week')
                    ->get();
                foreach ($data as $row) {
                    $weekNum = substr($row->week, 4, 2);
                    $pendapatanLabels[] = 'Minggu ' . $weekNum;
                    $pendapatanValues[] = $row->total;
                }
                break;

            case 'yearly':
                $data = $query->selectRaw('YEAR(tanggal_transaksi) as year, SUM(total) as total')
                    ->groupBy('year')
                    ->orderBy('year')
                    ->get();
                foreach ($data as $row) {
                    $pendapatanLabels[] = $row->year;
                    $pendapatanValues[] = $row->total;
                }
                break;

            case 'monthly':
            default:
                $data = $query->selectRaw('MONTH(tanggal_transaksi) as month, SUM(total) as total')
                    ->whereYear('tanggal_transaksi', Carbon::now()->year)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
                foreach ($data as $row) {
                    $pendapatanLabels[] = Carbon::create()->month($row->month)->format('M');
                    $pendapatanValues[] = $row->total;
                }
                break;
        }

        return view('dashboard.admin', compact(
            'user',
            'pelangganAktif',
            'promoAktif',
            'produk',
            'treatments',
            'pendapatanLabels',
            'pendapatanValues',
            'filter'
        ));
    }

    public function dokterForm()
    {
        return view('admin.dokter.tambah');
    }

    public function storeDokter(Request $request)
    {
        $request->validate([
            'nama_dokter' => 'required|string|max:100|unique:doctors,nama_dokter',
        ]);

        $lastId = DB::table('doctors')->max('id') ?? 0;
        $idBaru = $lastId + 1;

        DB::table('doctors')->insert([
            'id' => $idBaru,
            'nama_dokter' => $request->nama_dokter,
        ]);

        return redirect('/admin/dokter')->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function dokterIndex()
    {
        $dokter = DB::table('doctors')->get();
        return view('admin.dokter.index', compact('dokter'));
    }

    public function dokterEdit($id)
    {
        $dokter = DB::table('doctors')->where('id', $id)->first();

        if (!$dokter) {
            return redirect('/admin/dokter')->with('error', 'Data dokter tidak ditemukan.');
        }

        return view('admin.dokter.edit', compact('dokter'));
    }

    public function dokterUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_dokter' => 'required|string|max:100|unique:doctors,nama_dokter,' . $id,
        ]);

        DB::table('doctors')->where('id', $id)->update([
            'nama_dokter' => $request->nama_dokter,
        ]);

        return redirect('/admin/dokter')->with('success', 'Data dokter berhasil diperbarui.');
    }
}
