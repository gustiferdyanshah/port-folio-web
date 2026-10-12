<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pelanggan\PelangganLoginController;
use App\Http\Controllers\Pelanggan\KonsultasiController;
use App\Http\Controllers\Admin\TerapisController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Pelanggan\ReservasiController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\RewardController;
use App\Http\Controllers\Pelanggan\RiwayatTransaksiController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Pelanggan\ProdukController as PelangganProdukController;
use App\Http\Controllers\Admin\TreatmentController;
use App\Http\Controllers\Pelanggan\TreatmentController as PelangganTreatmentController;
use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Pelanggan\PromoController as PelangganPromoController;
use App\Http\Controllers\Pelanggan\HomeController;
use App\Http\Controllers\Dokter\DokterController;
use App\Http\Controllers\Admin\AdminDoctorController;
use App\Http\Controllers\Dokter\DoctorLoginController;
use App\Http\Controllers\Admin\KonsultasiAdminController;
use App\Http\Controllers\Admin\JadwalDokterController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Pelanggan\DashboardController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Owner\OwnerLaporanController;
use App\Http\Controllers\Owner\OwnerAnalisisController ;
use App\Http\Controllers\Owner\OwnerProductController;
use Illuminate\Support\Facades\Mail;


Route::get('/', [HomeController::class, 'index'])->name('beranda');
Route::get('/treatments-landing', [HomeController::class, 'treatments']) ->name('pelanggan.treatments.landing');
Route::get('/treatments-landing/{id}', [HomeController::class, 'treatmentShow'])->name('pelanggan.treatment.landing.show');
Route::get('/produk-landing', [HomeController::class, 'produkLanding'])->name('pelanggan.produk.landing');
Route::get('/produk-landing/{id}', [HomeController::class, 'produkLandingShow'])->name('pelanggan.produk.landing.show');
Route::get('/pelanggan/login', [PelangganLoginController::class, 'showLogin'])->name('login');
Route::post('/pelanggan/login', [PelangganLoginController::class, 'login']);
Route::get('/pelanggan/register', [PelangganLoginController::class, 'showRegister']);
Route::post('/pelanggan/register', [PelangganLoginController::class, 'register']);
Route::get('/pelanggan/logout', [PelangganLoginController::class, 'logout'])->middleware('auth:pelanggan');



Route::get('/pelanggan/dashboard', [PelangganLoginController::class, 'dashboard'])->middleware('auth:pelanggan');
Route::middleware('auth:pelanggan')->group(function () {

    Route::get('/pelanggan/dashboard', [DashboardController::class, 'index'])
        ->name('pelanggan.dashboard');
        
    Route::post('/pelanggan/logout', [PelangganLoginController::class, 'logout']);
    Route::get('/pelanggan/konsultasi',[KonsultasiController::class, 'form'])->name('pelanggan.konsultasi.form');
    Route::post('/pelanggan/konsultasi',[KonsultasiController::class, 'submit'] )->name('pelanggan.konsultasi.submit');

    Route::get('/pelanggan/reservasi',[ReservasiController::class, 'index'])->name('pelanggan.reservasi.index');
    Route::get('/pelanggan/reservasi/buat',[ReservasiController::class, 'create'])->name('pelanggan.reservasi.create');
    Route::post('/pelanggan/reservasi',[ReservasiController::class, 'store'])->name('pelanggan.reservasi.store');
    Route::get('/pelanggan/reservasi/detail/{id}',[ReservasiController::class, 'detail'] )->name('pelanggan.reservasi.detail');
    Route::post('/pelanggan/reservasi/konfirmasi/{id}',[ReservasiController::class, 'konfirmasiStore'] )->name('pelanggan.reservasi.konfirmasi.store');
    Route::get('/pelanggan/reservasi/aktif', function () {return view('pelanggan.reservasi_aktif');})->name('pelanggan.reservasi.aktif');
    Route::get('/pelanggan/transaksi',[RiwayatTransaksiController::class, 'index'])->name('pelanggan.transaksi.index');
    Route::get('/pelanggan/riwayat-transaksi', [RiwayatTransaksiController::class, 'index'])->name('pelanggan.riwayat-transaksi');
    Route::get('/pelanggan/produk', [PelangganProdukController::class, 'index'])->name('pelanggan.produk.index');
    Route::get('/{id}', [PelangganProdukController::class, 'show'])->name('produk.show');
    Route::get('/pelanggan/treatment', [PelangganTreatmentController::class, 'index'])->name('pelanggan.treatment.index');
    Route::get('/pelanggan/treatment/{id}', [PelangganTreatmentController::class, 'show'])->name('pelanggan.treatment.show');
});

Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::get('/admin/logout', [AuthController::class, 'logout'])->middleware('auth')->name('admin.logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dokter', [AdminController::class, 'dokterIndex']);
    Route::get('/dokter/tambah', [AdminController::class, 'dokterForm']);
    Route::post('/dokter/tambah', [AdminController::class, 'storeDokter']);
    Route::get('/dokter/{id}/edit', [AdminController::class, 'dokterEdit']);
    Route::post('/dokter/{id}/update', [AdminController::class, 'dokterUpdate']);

    Route::get('/dokter/register', [AdminDoctorController::class, 'create'])->name('dokter.register');
    Route::post('/dokter/register', [AdminDoctorController::class, 'store'])->name('dokter.store');
    Route::get('/dokter/{id}/akun/edit', [AdminDoctorController::class, 'editAkun'])->name('dokter.akun.edit');
    Route::post('/dokter/{id}/akun/update', [AdminDoctorController::class, 'updateAkun'])->name('dokter.akun.update');
    Route::get('/jadwal', [KonsultasiAdminController::class, 'index'])->name('admin.konsultasi');
    Route::get('/jadwal/{id}/detail', [KonsultasiAdminController::class, 'detail'])->name('konsultasi.detail');
    Route::get('/dokter/jadwal',[JadwalDokterController::class, 'index'])->name('dokter.jadwal');
    Route::post('/dokter/jadwal',[JadwalDokterController::class, 'store'])->name('dokter.jadwal.store');

    Route::get('/terapis', [TerapisController::class, 'index']);
    Route::get('/terapis/tambah', [TerapisController::class, 'create']);
    Route::post('/terapis/tambah', [TerapisController::class, 'store']);
    Route::get('/terapis/{id}/edit', [TerapisController::class, 'edit']);
    Route::post('/terapis/{id}/update', [TerapisController::class, 'update']);

    Route::get('/terapis/ketersediaan',[TerapisController::class, 'ketersediaan'])->name('terapis.ketersediaan');
    Route::get('/reservasi', [AdminReservationController::class, 'index'])->name('reservasi.index');
    Route::get('reservasi/{id}', [AdminReservationController::class, 'show'])->name('reservasi.show');
    Route::post('reservasi/{id}/update', [AdminReservationController::class, 'update'])->name('reservasi.update');

    Route::get('/treatment', [TreatmentController::class, 'index'])->name('treatment.index');
    Route::get('/treatment/tambah', [TreatmentController::class, 'create'])->name('treatment.create');
    Route::post('/treatment', [TreatmentController::class, 'store'])->name('treatment.store');
    Route::get('/treatment/{id}/edit', [TreatmentController::class, 'edit'])->name('treatment.edit');
    Route::put('/treatment/{id}', [TreatmentController::class, 'update'])->name('treatment.update');
    Route::delete('/treatment/{id}', [TreatmentController::class, 'destroy'])->name('treatment.destroy');

    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::post('/produk/{id}/update', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    
    Route::get('/konsultasi', [KonsultasiAdminController::class, 'index'])->name('konsultasi');
    Route::get('/konsultasi/{id}', [KonsultasiAdminController::class, 'detail'])->name('konsultasi.detail');
    Route::post('/konsultasi/{id}/update', [KonsultasiAdminController::class, 'update'])->name('konsultasi.update');
    Route::put('/konsultasi/{id}/batal', [KonsultasiAdminController::class, 'batal']) ->name('konsultasi.batal');
    Route::post('/konsultasi/{id}/ajukan', [KonsultasiAdminController::class, 'ajukan'])->name('konsultasi.ajukan');
 
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create/{konsultasi}',[TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/store',[TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::resource('promos', AdminPromoController::class);
});


    Route::get('/produk', [PelangganProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/{id}', [PelangganProdukController::class, 'show'])->name('produk.show');
    Route::get('/treatments', [PelangganTreatmentController::class, 'index'])->name('pelanggan.treatments.index');
Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/promos', [PelangganPromoController::class, 'index'])->name('promos.index');
    Route::get('/promo/{id}', [PelangganPromoController::class, 'show'])->name('promo.show');
});
    Route::get('/treatments/{id}', [PelangganTreatmentController::class, 'show'])
        ->name('pelanggan.treatments.show');

Route::prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/login', [DoctorLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [DoctorLoginController::class, 'login'])->name('login.submit');
});

Route::middleware('auth:doctor')->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'dashboard'])->name('dashboard');
    Route::get('/jadwal-konsultasi', [DokterController::class, 'jadwalKonsultasi'])->name('jadwal.konsultasi');
    Route::get('/konsultasi/{id}', [DokterController::class, 'detailKonsultasi'])->name('konsultasi.detail');
    Route::post('/konsultasi/{id}/simpan', [DokterController::class, 'simpanHasilKonsultasi'])->name('konsultasi.simpan');
    Route::post('/logout', [DoctorLoginController::class, 'logout'])->name('logout');

});

Route::prefix('owner')
    ->middleware(['auth', 'role:owner'])
    ->name('owner.')
    ->group(function () {
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/laporan/transaksi', [OwnerLaporanController::class, 'transaksi'])->name('laporan.transaksi');
        Route::get('/laporan/pendapatan', [OwnerLaporanController::class, 'pendapatan'])->name('laporan.pendapatan');
        Route::get('/analisis/penjualan', [OwnerAnalisisController::class, 'penjualan'])->name('analisis.penjualan');
        Route::get('/produk', [OwnerProductController::class, 'index'])->name('produk.index');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
Route::get('/test-email', function () {
    Mail::raw('Test email dari Laravel 10 (Mailtrap SMTP)', function ($message) {
        $message->to('ferdygtloh@gmail.com')
                ->subject('Test Email via Queue');
    })->queue();

    return 'Email masuk antrian (queue). Jalankan queue worker untuk memprosesnya.';
});