<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerAnalisisController extends Controller
{
    public function penjualan(Request $request)
    {
        $startDateInput = $request->query('start_date');
        $endDateInput = $request->query('end_date');
        $excludeUnknown = $request->query('exclude_unknown');

        if ($startDateInput) {
            $startDateCarbon = Carbon::parse($startDateInput)->startOfDay();
        } else {
            $startDateCarbon = Carbon::now()->subMonth()->startOfDay();
        }

        if ($endDateInput) {
            $endDateCarbon = Carbon::parse($endDateInput)->endOfDay();
        } else {
            $endDateCarbon = Carbon::now()->endOfDay();
        }

        $startDateForQuery = $startDateCarbon->toDateTimeString();
        $endDateForQuery = $endDateCarbon->toDateTimeString();

        $startDateForForm = $startDateCarbon->format('Y-m-d');
        $endDateForForm = $endDateCarbon->format('Y-m-d');

        $query = DB::table('transactions_details')
            ->leftJoin('reservasi_service', 'reservasi_service.id', '=', 'transactions_details.reservasi_service_id')
            ->leftJoin('services', 'services.id', '=', 'reservasi_service.services_id')
            ->leftJoin('treatments', 'treatments.id', '=', 'services.treatments_id')
            ->leftJoin('transactions', 'transactions.id', '=', 'transactions_details.transactions_id')
            ->select(
                DB::raw('COALESCE(treatments.nama_treatment, "Unknown Treatment") as nama_produk'),
                DB::raw('COUNT(transactions_details.id) as total_qty'),
                DB::raw('SUM(transactions_details.harga) as total_revenue')
            )
            ->whereBetween('transactions.tanggal_transaksi', [$startDateForQuery, $endDateForQuery]);

        if ($excludeUnknown) {
            $query->havingRaw('nama_produk != ?', ['Unknown Treatment']);
        }

        $data = $query->groupBy('nama_produk')
            ->orderByDesc('total_revenue')
            ->get();

        $unknownCount = $data->where('nama_produk', 'Unknown Treatment')->sum('total_qty');

        return view('owner.penjualan', [
            'data' => $data,
            'startDate' => $startDateForForm,
            'endDate' => $endDateForForm,
            'excludeUnknown' => $excludeUnknown,
            'unknownCount' => $unknownCount,
        ]);
    }

    public function unknownTreatmentDetails(Request $request)
    {
        $startDateInput = $request->query('start_date');
        $endDateInput = $request->query('end_date');

        if ($startDateInput) {
            $startDateCarbon = Carbon::parse($startDateInput)->startOfDay();
        } else {
            $startDateCarbon = Carbon::now()->subMonth()->startOfDay();
        }

        if ($endDateInput) {
            $endDateCarbon = Carbon::parse($endDateInput)->endOfDay();
        } else {
            $endDateCarbon = Carbon::now()->endOfDay();
        }

        $startDateForQuery = $startDateCarbon->toDateTimeString();
        $endDateForQuery = $endDateCarbon->toDateTimeString();

        $details = DB::table('transactions_details as td')
            ->leftJoin('reservasi_service as rs', 'rs.id', '=', 'td.reservasi_service_id')
            ->join('transactions as t', 't.id', '=', 'td.transactions_id')
            ->select(
                'td.id as transaksi_detail_id',
                'td.harga',
                't.tanggal_transaksi',
                'td.reservasi_service_id'
            )
            ->where(function ($query) {
                $query->where('td.reservasi_service_id', 0)
                      ->orWhereNull('rs.id');
            })
            ->whereBetween('t.tanggal_transaksi', [$startDateForQuery, $endDateForQuery])
            ->orderBy('t.tanggal_transaksi', 'desc')
            ->get();

        return view('owner.unknown_treatment_details', [
            'details' => $details,
            'startDate' => $startDateCarbon->format('Y-m-d'),
            'endDate' => $endDateCarbon->format('Y-m-d'),
        ]);
    }
}
