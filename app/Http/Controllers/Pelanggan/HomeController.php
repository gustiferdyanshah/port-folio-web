<?php
// untuk landing pagenya
namespace App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Treatments;

class HomeController extends Controller
{
    public function index()
    {
        $produk = Produk::all();

        return view('pelanggan.beranda', compact('produk'));
    }

    public function produkLanding()
    {
        $produk = Produk::all();
        return view('pelanggan.produk_landing', compact('produk'));
    }

    public function produkLandingShow($id)
    {
        $produk = Produk::findOrFail($id);
        return view('pelanggan.produk_show_landing', compact('produk'));
    }
    
    public function treatments()
    {
        $treatments = Treatments::all();
        return view('pelanggan.treatments_landing', compact('treatments'));
    }

    public function treatmentShow($id)
    {
        $treatment = Treatments::findOrFail($id);
        return view('pelanggan.treatments_show_landing', compact('treatment'));
    }
}
