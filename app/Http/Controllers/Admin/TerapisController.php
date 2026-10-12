<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TerapisController extends Controller
{
    public function index()
    {
        $terapis = DB::table('terapis')
                        ->orderBy('nama_terapis')
                        ->paginate(6);

        return view('admin.terapis.index', compact('terapis'));
    }

    public function create()
    {
        return view('admin.terapis.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_terapis' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:P,L',
            'no_wa' => 'required|string|max:45',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $lastId = DB::table('terapis')->max('id') ?? 0;
        $idBaru = $lastId + 1;

        DB::table('terapis')->insert([
            'id' => $idBaru,
            'nama_terapis' => $request->nama_terapis,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_wa' => $request->no_wa,
            'status' => $request->status,
        ]);

        return redirect('/admin/terapis')->with('success', 'Terapis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $terapis = DB::table('terapis')->where('id', $id)->first();

        if (!$terapis) {
            return redirect('/admin/terapis')->with('error', 'Data terapis tidak ditemukan.');
        }

        return view('admin.terapis.edit', compact('terapis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_terapis' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:P,L',
            'no_wa' => 'required|string|max:45',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        DB::table('terapis')->where('id', $id)->update([
            'nama_terapis' => $request->nama_terapis,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_wa' => $request->no_wa,
            'status' => $request->status,
        ]);

        return redirect('/admin/terapis')->with('success', 'Data terapis berhasil diperbarui.');
    }

    public function ketersediaan(Request $request)
    {
        $tanggal = $request->tanggal ?? date('Y-m-d');
        $status  = $request->status;

        $query = DB::table('terapis as t')
            ->leftJoin('reservasi_service as rs', function ($join) use ($tanggal) {
                $join->on('t.id', '=', 'rs.terapis_id')
                     ->where('rs.status', 'berjalan')
                     ->whereDate('rs.tanggal_booking', $tanggal);
            })
            ->leftJoin('appointments_doctor as a', 'rs.appointments_id', '=', 'a.id')
            ->leftJoin('customer as c', 'a.customer_id', '=', 'c.id')
            ->leftJoin('treatments as tr', 'rs.services_id', '=', 'tr.id')
            ->select(
                't.id',
                't.nama_terapis',
                DB::raw("
                    CASE 
                        WHEN rs.id IS NULL THEN 'tersedia'
                        ELSE 'melayani'
                    END AS status
                "),
                'c.nama_lengkap as pasien',
                'tr.nama_treatment',
                'rs.tanggal_booking',
                'rs.jam_booking',
                'rs.jam_ending'
            );

        if ($status) {
            if ($status === 'tersedia') {
                $query->whereNull('rs.id');
            } elseif ($status === 'melayani') {
                $query->whereNotNull('rs.id');
            }
        }

        $data = $query->orderBy('t.nama_terapis')->get();

        return view('admin.terapis.ketersediaan_terapis', compact('data', 'tanggal'));
    }
}
