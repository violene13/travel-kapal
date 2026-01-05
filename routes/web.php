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
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');

    // LOGIN DARI MODAL (JIKA DIPAKAI)
    Route::post('/login-modal', [LoginController::class, 'loginModal'])->name('login.modal');

    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register'])->name('register.process');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AREA ADMIN (AUTH:WEB)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {
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

    // ✅ ADMIN TRAVEL SAJA
    Route::middleware('role:admin_travel')->group(function () {
        Route::get('/dashboard/travel', [DashboardController::class, 'travel'])
            ->name('admin.travel.dashboard');
    });

    // ✅ ADMIN PELAYARAN SAJA
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

    // AJAX
    Route::get('/admin/pelayaran/get-kelas/{id_jalur}', [JadwalPelayaranController::class, 'getKelas']);
    Route::get('/admin/pelayaran/get-harga/{id_jalur}/{kelas}', [JadwalPelayaranController::class, 'getHarga']);

    // ======================
    // TICKETING
    // ======================
    Route::resource('ticketing', TicketingController::class);

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

    // ❗ WAJIB TETAP ADA
    Route::get('/get-penumpang-by-name',
        [PemesananController::class, 'getPenumpangByName']
    )->name('getPenumpangByName');
});

/*
|--------------------------------------------------------------------------
| AREA PENUMPANG (AUTH:PENUMPANG)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:penumpang')->group(function () {

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

    Route::get('/profil', [PenumpangController::class, 'profil'])->name('penumpang.profil');
    Route::post('/profil/update', [PenumpangController::class, 'updateProfil'])
        ->name('penumpang.profil.update');
});