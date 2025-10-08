<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Penumpang;
use App\Models\DataKapal;
use App\Models\JalurPelayaran;
use App\Models\DataPelabuhan;

class DashboardController extends Controller
{
    // =====================
    // Dashboard Admin Travel
    // =====================
    public function travel()
    {
        $jumlahPemesanan = Pemesanan::count();
        $jumlahPenumpang = Penumpang::count();

        $pemesanan = Pemesanan::latest('id_pemesanan')
                            ->take(5)
                            ->get();

        return view('admin.travel.dashboard', compact('pemesanan', 'jumlahPemesanan', 'jumlahPenumpang'));
    }

    // =====================
    // Dashboard Admin Pelayaran
    // =====================
    public function pelayaran()
    {
        $totalKapal      = DataKapal::count();
        $totalPelabuhan  = DataPelabuhan::count();
        $totalJalur      = JalurPelayaran::count();

        // kalau mau menampilkan aktivitas terbaru juga
        $aktivitasTerbaru = Pemesanan::with(['penumpang', 'jadwal.kapal'])
                                ->latest('id_pemesanan')
                                ->take(5)
                                ->get();

        return view('admin.pelayaran.dashboard', compact('totalKapal', 'totalPelabuhan', 'totalJalur', 'aktivitasTerbaru'));
    }

    // =====================
    // Dashboard Penumpang
    // =====================
    public function penumpang()
    {
        $jumlahPemesanan = Pemesanan::where('id_penumpang', auth()->id())->count();

        return view('penumpang.dashboard', compact('jumlahPemesanan'));
    }
}
