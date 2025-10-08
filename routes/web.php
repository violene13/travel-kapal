<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PenumpangController;
use App\Http\Controllers\PerubahanPembatalanController;
use App\Http\Controllers\JalurController;
use App\Http\Controllers\DataKapalController;
use App\Http\Controllers\DataPelabuhanController;
use App\Http\Controllers\JadwalPelayaranController;

// =====================
// ROOT -> arahkan ke login
// =====================
Route::get('/', function () {
    return redirect()->route('login.form');
});

// =====================
// AUTH
// =====================
// FORM LOGIN
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');

// PROSES LOGIN
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// =====================
// DASHBOARD PER ROLE
// =====================
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Dashboard umum

// Dashboard Travel
Route::get('/dashboard/travel', [DashboardController::class, 'travel'])
    ->name('admin.travel.dashboard');

// Dashboard Pelayaran
Route::get('/dashboard/pelayaran', [DashboardController::class, 'pelayaran'])
    ->name('admin.pelayaran.dashboard');

// Dashboard Penumpang
Route::get('/dashboard/penumpang', [DashboardController::class, 'penumpang'])
    ->name('penumpang.dashboard');

// =====================
// MASTER DATA
// =====================
Route::resource('jalurpelayaran', JalurController::class);
Route::resource('datakapal', DataKapalController::class);
Route::resource('datapelabuhan', DataPelabuhanController::class);

// Route AJAX untuk dropdown pelabuhan tujuan
Route::get('/get-tujuan/{asal}', [DataPelabuhanController::class, 'getTujuan'])
    ->name('pelabuhan.getTujuan');

Route::resource('jadwalpelayaran', JadwalPelayaranController::class);

// =====================
// ADMIN TRAVEL AREA
// =====================
Route::prefix('admin/travel')->group(function () {
    
    // Pemesanan
    Route::resource('pemesanan', PemesananController::class);
    Route::get('pemesanan/{id}/cetak', [PemesananController::class, 'cetakTiket'])
        ->name('pemesanan.cetak');

    // Perubahan & Pembatalan
    Route::get('perubahan-pembatalan', [PerubahanPembatalanController::class, 'index'])
        ->name('perubahan_pembatalan.index');
    Route::get('perubahan-pembatalan/process/{id}', [PerubahanPembatalanController::class, 'process'])
        ->name('perubahan_pembatalan.process');
    Route::delete('perubahan-pembatalan/{id}', [PerubahanPembatalanController::class, 'destroy'])
        ->name('perubahan_pembatalan.destroy');

    // Penumpang
    Route::get('penumpang', [PenumpangController::class, 'index'])
        ->name('penumpang.index');
    Route::delete('penumpang/{id}', [PenumpangController::class, 'destroy'])
        ->name('penumpang.destroy');
});
