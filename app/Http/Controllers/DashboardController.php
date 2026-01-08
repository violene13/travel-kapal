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
    // Dashboard Utama (Redirect)
    // =====================
    public function index()
    {
        return redirect()->route('admin.pelayaran.dashboard');
    }

    // =====================
    // Dashboard Admin Travel
    // =====================
    public function travel()
    {
        
        $jumlahPemesanan = Pemesanan::count();
        $jumlahPenumpang = Penumpang::count();

        // Data pemesanan terbaru
        $pemesanan = Pemesanan::latest('id_pemesanan')
                            ->take(5)
                            ->get();

        // grafik pemesanan per bulan
        $pemesananBulanan = Pemesanan::selectRaw('MONTH(tanggal_pesan) AS bulan, COUNT(*) AS total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulanPemesanan = $pemesananBulanan->pluck('bulan')->map(function ($b) {
            return \DateTime::createFromFormat('!m', $b)->format('M');
        });

        $dataPemesanan = $pemesananBulanan->pluck('total');

        $bulanPenumpang = [];
        $dataPenumpang = [];

        return view('Admin.travel.dashboard', compact(
            'pemesanan',
            'jumlahPemesanan',
            'jumlahPenumpang',
            'bulanPemesanan',
            'dataPemesanan',
            'bulanPenumpang',
            'dataPenumpang'
        ));
    }

    // =====================
    // Dashboard Admin Pelayaran
    // =====================
    public function pelayaran()
    {
       
        $totalKapal     = DataKapal::count();
        $totalPelabuhan = DataPelabuhan::count();
        $totalJalur     = JalurPelayaran::count();

        $totalPenumpang = \App\Models\Penumpang::count();

        $totalTiket = Pemesanan::where('status', 'Confirmed')->count();

        $aktivitasTerbaru = Pemesanan::with([
                'penumpang',
                'jadwal.kapal',
                'jadwal.jalur'
            ])
            ->orderByDesc('id_pemesanan')
            ->limit(5)
            ->get();

        $grafikStatus = Pemesanan::select(
                'status',
                \DB::raw('COUNT(*) as total')
            )
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('Admin.pelayaran.dashboard', compact(
            'totalKapal',
            'totalPelabuhan',
            'totalJalur',
            'totalPenumpang',
            'totalTiket',
            'aktivitasTerbaru',
            'grafikStatus'
        ));
    }
}   