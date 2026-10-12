<?php
namespace App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Treatments;
use App\Models\Promo;
use App\Models\AppointmentsDoctor;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth('pelanggan')->user();
        $promo = Promo::whereDate('tanggal_mulai', '<=', now())
                      ->whereDate('tanggal_selesai', '>=', now())
                      ->get();

        $produk = collect();
        if ($user) {
            $appointments = AppointmentsDoctor::where('customer_id', $user->id)
                                ->where('status', 'selesai')
                                ->get();

            $produkIds = [];
            foreach ($appointments as $app) {
                if ($app->rekomendasi_products) {
                    $ids = array_map('intval', explode(',', $app->rekomendasi_products));
                    $produkIds = array_merge($produkIds, $ids);
                }
            }
            $produkIds = array_unique($produkIds);

            if (!empty($produkIds)) {
                $produk = Produk::whereIn('id', $produkIds)->take(3)->get();
            }
        }

    
        if ($produk->isEmpty()) {
            $produk = Produk::latest()->take(3)->get();
        }

        $treatment = collect();
        if ($user) {
            $treatmentIds = [];
            foreach ($appointments as $app) {
                if ($app->rekomendasi_treatments) {
                    $ids = array_map('intval', explode(',', $app->rekomendasi_treatments));
                    $treatmentIds = array_merge($treatmentIds, $ids);
                }
            }
            $treatmentIds = array_unique($treatmentIds);

            if (!empty($treatmentIds)) {
                $treatment = Treatments::whereIn('id', $treatmentIds)->take(3)->get();
            }
        }

        return view('dashboard.pelanggan', compact('user', 'promo', 'produk', 'treatment'));
    }
}
