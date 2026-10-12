<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::paginate(6);
        return view('pelanggan.produk', compact('produks'));
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id); 
        return view('pelanggan.produk_detail', compact('produk'));
    }
}
