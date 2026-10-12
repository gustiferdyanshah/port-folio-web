<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalPendapatan = DB::table('transactions')->sum('total');
        $totalTransaksi  = DB::table('transactions')->count();
        $totalCustomer   = DB::table('customer')->count();
        $totalReservasi  = DB::table('reservasi_service')->count();

        $filter = $request->query('filter', 'weekly');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = DB::table('transactions')->whereNotNull('tanggal_transaksi');

        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('tanggal_transaksi', [$start, $end]);
        } else {
            if ($filter == 'weekly') {
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
            } elseif ($filter == 'monthly') {
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
            } elseif ($filter == 'yearly') {
                $start = Carbon::now()->startOfYear();
                $end = Carbon::now()->endOfYear();
            }
            $query->whereBetween('tanggal_transaksi', [$start, $end]);
        }

        $labels = [];
        $values = [];

        switch ($filter) {
            case 'yearly':
                $data = $query
                    ->selectRaw('YEAR(tanggal_transaksi) as label, SUM(total) as total')
                    ->groupBy('label')
                    ->orderBy('label')
                    ->get();

                foreach ($data as $row) {
                    $labels[] = $row->label;
                    $values[] = $row->total;
                }
                break;

            case 'monthly':
                $data = $query
                    ->selectRaw('MONTH(tanggal_transaksi) as label, SUM(total) as total')
                    ->groupBy('label')
                    ->orderBy('label')
                    ->get();

                foreach ($data as $row) {
                    $labels[] = Carbon::create()->month($row->label)->format('M');
                    $values[] = $row->total;
                }
                break;

            case 'weekly':
            default:
                $data = $query
                    ->selectRaw('YEARWEEK(tanggal_transaksi, 1) as label, SUM(total) as total')
                    ->groupBy('label')
                    ->orderBy('label')
                    ->get();

                foreach ($data as $row) {
                    $weekNumber = substr($row->label, 4, 2);
                    $labels[] = 'Minggu ' . $weekNumber;
                    $values[] = $row->total;
                }
                break;
        }

        $topProduk = DB::table('products')
            ->join('transactions_details', 'products.id', '=', 'transactions_details.reservasi_service_id')
            ->select('products.nama', DB::raw('COUNT(transactions_details.id) as total'))
            ->groupBy('products.id', 'products.nama')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topTreatment = DB::table('treatments')
            ->join('transactions_details', 'treatments.id', '=', 'transactions_details.reservasi_service_id')
            ->select('treatments.nama_treatment', DB::raw('COUNT(transactions_details.id) as total'))
            ->groupBy('treatments.id', 'treatments.nama_treatment')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('dashboard.owner', compact(
            'totalPendapatan',
            'totalTransaksi',
            'totalCustomer',
            'totalReservasi',
            'labels',
            'values',
            'filter',
            'topProduk',
            'topTreatment',
            'startDate',
            'endDate'
        ));
    }
}
