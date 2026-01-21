<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PemesananPelayaranController;
use App\Http\Controllers\PemesananPenumpangController;
use App\Http\Controllers\PenumpangController;
use App\Http\Controllers\JalurController;
use App\Http\Controllers\DataKapalController;
use App\Http\Controllers\DataPelabuhanController;
use App\Http\Controllers\JadwalPelayaranController;
use App\Http\Controllers\JadwalPenumpangController;
use App\Http\Controllers\TicketingController;
use App\Http\Controllers\SealineController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\BantuanController;
use App\Http\Controllers\PembayaranController;


/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', [SealineController::class, 'index'])->name('sealine.homes.index');
Route::get('/aboutus', [AboutUsController::class, 'index'])->name('sealine.aboutus.index');
Route::get('/bantuan', [BantuanController::class, 'index'])->name('sealine.bantuan.index');
Route::get('/bantuan/cari', [BantuanController::class, 'cari'])->name('sealine.bantuan.cari');

/*
|--------------------------------------------------------------------------
| JADWAL PUBLIK (PENUMPANG)
|--------------------------------------------------------------------------
*/
Route::get('/jadwal-lengkap', [JadwalPenumpangController::class, 'jadwalLengkap'])->name('jadwal.lengkap');
Route::get('/jadwal-lengkap/detail/{id}', [JadwalPenumpangController::class, 'detail'])->name('jadwal.detail');
Route::get('/cari-jadwal', [JadwalPenumpangController::class, 'cari'])->name('jadwal.cari');

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN / REGISTER)
|--------------------------------------------------------------------------
*/

// FORM LOGIN (WAJIB ADA, TANPA guest)
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

// PROSES LOGIN (HANYA UNTUK GUEST)
Route::middleware('guest')->group(function () {

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.process');

    Route::post('/login-modal', [LoginController::class, 'loginModal'])
        ->name('login.modal');

    Route::get('/register', [LoginController::class, 'showRegisterForm'])
        ->name('register');

    Route::post('/register', [LoginController::class, 'register'])
        ->name('register.process');
});

// LOGOUT (HARUS AUTH)
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| AREA ADMIN (AUTH:WEB)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {

// ======================
// TICKETING
// ======================

    Route::prefix('ticketing')->name('ticketing.')->group(function () {

    Route::get('/', [TicketingController::class, 'index'])
        ->name('index');

    Route::get('/create', [TicketingController::class, 'create'])
        ->name('create');

    Route::post('/', [TicketingController::class, 'store'])
        ->name('store');

    //  PAKAI GROUP KEY
    Route::get('/{groupKey}/edit', [TicketingController::class, 'edit'])
        ->name('edit');

    Route::put('/{groupKey}', [TicketingController::class, 'update'])
        ->name('update');

    Route::delete('/{groupKey}', [TicketingController::class, 'destroy'])
        ->name('destroy');
});

    
/*
|--------------------------------------------------------------------------
| DATA PENUMPANG (ADMIN)
|--------------------------------------------------------------------------
*/
Route::prefix('penumpang')->name('penumpang.')->group(function () {

    // PENUMPANG TRAVEL
    Route::prefix('penumpangtravel')->name('penumpangtravel.')->group(function () {
        Route::get('/', [PenumpangController::class, 'index'])
            ->name('index');

        Route::get('/create', [PenumpangController::class, 'create'])
            ->name('create');

        Route::post('/', [PenumpangController::class, 'store'])
            ->name('store');

        Route::get('/{id}/edit', [PenumpangController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [PenumpangController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [PenumpangController::class, 'destroy'])
            ->name('destroy');
    });

    // PENUMPANG PELAYARAN
    Route::prefix('penumpangpelayaran')->name('penumpangpelayaran.')->group(function () {
        Route::get('/', [PenumpangController::class, 'indexPelayaran'])
            ->name('index');

        Route::delete('/{id}', [PenumpangController::class, 'destroyPelayaran'])
            ->name('destroy');
    });

});


    // DASHBOARD UMUM
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ADMIN TRAVEL
    Route::middleware('role:admin_travel')->group(function () {
        Route::get('/dashboard/travel', [DashboardController::class, 'travel'])
            ->name('admin.travel.dashboard');
    });

    // ADMIN PELAYARAN 
    Route::middleware('role:admin_pelayaran')->group(function () {
        Route::get('/dashboard/pelayaran', [DashboardController::class, 'pelayaran'])
            ->name('admin.pelayaran.dashboard');
    });

    // ======================
    // MASTER DATA
    // ======================
    Route::resource('jalurpelayaran', JalurController::class);
    Route::resource('datakapal', DataKapalController::class);
    Route::resource('datapelabuhan', DataPelabuhanController::class);

    Route::get('/get-tujuan/{asal}',
        [DataPelabuhanController::class, 'getTujuan']
    )->name('pelabuhan.getTujuan');

    // ======================
    // JADWAL PELAYARAN
    // ======================
    Route::prefix('jadwalpelayaran')->name('jadwalpelayaran.')->group(function () {
        Route::get('/', [JadwalPelayaranController::class, 'index'])->name('index');
        Route::get('/create', [JadwalPelayaranController::class, 'create'])->name('create');
        Route::post('/store', [JadwalPelayaranController::class, 'store'])->name('store');
        Route::get('/edit/{jadwalpelayaran}', [JadwalPelayaranController::class, 'edit'])->name('edit');
        Route::put('/update/{jadwalpelayaran}', [JadwalPelayaranController::class, 'update'])->name('update');
        Route::delete('/destroy/{jadwalpelayaran}', [JadwalPelayaranController::class, 'destroy'])->name('destroy');
    });
    /*
    |--------------------------------------------------------------------------
    | API JADWAL & TICKETING (AJAX)
    |--------------------------------------------------------------------------
    | Digunakan untuk:
    | - Ambil kelas berdasarkan jalur + kapal
    | - Ambil kategori tiket (dewasa / anak / bayi)
    | - Ambil harga tiket
    |
    */

    Route::prefix('api')->name('api.')->group(function () {

        // ======================
        // KELAS TIKET
        // ======================
        Route::get('/jalur/{id_jalur}/kelas',
            [JadwalPelayaranController::class, 'getKelas']
        )->name('jalur.kelas');

        // ======================
        // KATEGORI TIKET
        // ======================
        Route::get('/jalur/{id_jalur}/kategori',
            [JadwalPelayaranController::class, 'getKategori']
        )->name('jalur.kategori');

        // ======================
        // HARGA TIKET
        // ======================
        Route::get('/jalur/{id_jalur}/harga',
            [JadwalPelayaranController::class, 'getHarga']
        )->name('jalur.harga');

    });



    // ======================
    // PEMESANAN ADMIN
    // ======================
    Route::prefix('pemesanan/pemesanantravel')->name('pemesanan.pemesanantravel.')->group(function () {
        Route::get('/', [PemesananController::class, 'index'])->name('index');
        Route::get('/create', [PemesananController::class, 'create'])->name('create');
        Route::post('/', [PemesananController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PemesananController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PemesananController::class, 'update'])->name('update');
        Route::delete('/{id}', [PemesananController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [PemesananController::class, 'show'])->name('show');
        Route::patch('/{id}/update-status', [PemesananController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::prefix('pemesanan/pemesananpelayaran')->name('pemesanan.pemesananpelayaran.')->group(function () {
        Route::get('/', [PemesananPelayaranController::class, 'index'])->name('index');
        Route::get('/{id}', [PemesananPelayaranController::class, 'show'])->name('show');
    });

    Route::get('/get-penumpang-by-name',
        [PemesananController::class, 'getPenumpangByName']
    )->name('getPenumpangByName');
});

/*
|--------------------------------------------------------------------------
| AREA PENUMPANG (AUTH:role PENUMPANG)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'role:penumpang'])->group(function () {

    Route::get('/pemesanan/pengguna', [PemesananPenumpangController::class, 'index'])
        ->name('pemesanan.pemesananpengguna.index');

    Route::get('/pemesanan/pengguna/create/{id_jadwal}',
        [PemesananPenumpangController::class, 'create'])
        ->name('pemesanan.pemesananpengguna.create');

    Route::post('/pemesanan/pengguna/store/{id_jadwal}',
        [PemesananPenumpangController::class, 'store'])
        ->name('pemesanan.pemesananpengguna.store');

    Route::get('/pemesanan/pengguna/detail/{id}',
        [PemesananPenumpangController::class, 'show'])
        ->name('pemesanan.pemesananpengguna.show');

    Route::put('/pemesanan/{id}/batal',
        [PemesananPenumpangController::class, 'batal'])
        ->name('pemesanan.pemesananpengguna.batal');

    Route::delete('/pemesanan/{id}/hapus',
        [PemesananPenumpangController::class, 'hapus'])
        ->name('pemesanan.pemesananpengguna.hapus');

    Route::get('/pembayaran/{id_pemesanan}',
        [PembayaranController::class, 'show'])
        ->name('pembayaran.show');

    Route::get('/profil', [PenumpangController::class, 'profil'])
        ->name('penumpang.profil');

    Route::post('/profil/update', [PenumpangController::class, 'updateProfil'])
        ->name('penumpang.profil.update');

         Route::get(
        '/pemesanan/{id}/eticket',
        [PemesananPenumpangController::class, 'eticket']
    )->name('pemesanan.eticket');

});

Route::post('/pembayaran/{id_pemesanan}', 
    [PembayaranController::class, 'proses']
)->name('pembayaran.proses');

Route::get('/pembayaran/{id_pemesanan}/sukses',
    [PembayaranController::class, 'sukses']
)->name('pembayaran.sukses');
