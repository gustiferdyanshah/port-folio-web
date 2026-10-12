<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerProductController extends Controller
{
    public function index(Request $request)
    {
        $filterStok = $request->query('stok');

        $query = DB::table('products')
            ->select(
                'products.id',
                'products.nama as nama_produk',
                'products.stok'
            );

        if ($filterStok === 'tersedia') {
            $query->where('products.stok', '>', 0);
        } elseif ($filterStok === 'habis') {
            $query->where('products.stok', '<=', 0);
        }

        $query->orderBy('products.nama');

        $produk = $query->get();

        return view('owner.produk', compact('produk'));
    }
}
