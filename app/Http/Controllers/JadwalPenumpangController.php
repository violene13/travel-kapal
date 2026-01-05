<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPelayaran;
use App\Models\JalurPelayaran;
use App\Models\DataKapal;
use App\Models\DataPelabuhan;
use App\Models\Ticketing;

class JadwalPenumpangController extends Controller
{
    // Halaman jadwal lengkap (tanpa filter)
    public function jadwalLengkap()
    {
        $jadwal = JadwalPelayaran::with([
                'kapal',
                'jalur.pelabuhanAsal',
                'jalur.pelabuhanTujuan',
                'ticketings'
            ])
            ->orderBy('tanggal_berangkat', 'ASC')
            ->get();

        $pelabuhan = DataPelabuhan::all();

        // default jumlah penumpang
        $dewasa = 1;
        $anak   = 0;
        $bayi   = 0;

        return view('jadwalpelayaran.lengkap', compact(
            'jadwal', 'pelabuhan', 
            'dewasa', 'anak', 'bayi'
        ));
    }

    // Detail jadwal
    public function detail($id)
    {
        $jadwal = JadwalPelayaran::with([
                'kapal',
                'jalur.pelabuhanAsal',
                'jalur.pelabuhanTujuan'
            ])
            ->where('id_jadwal', $id)
            ->firstOrFail();

        return view('jadwalpelayaran.detail', compact('jadwal'));
    }

    // Pencarian jadwal
    public function cari(Request $request)
    {
        $asal = $request->asal;
        $tujuan = $request->tujuan;
        $kelas = $request->kelas;
        $tanggal = $request->tanggal_berangkat;

        // AMBIL JUMLAH PENUMPANG
        $dewasa = $request->dewasa ?? 1;
        $anak   = $request->anak   ?? 0;
        $bayi   = $request->bayi   ?? 0;

        $jadwal = JadwalPelayaran::with([
                'kapal',
                'jalur.pelabuhanAsal',
                'jalur.pelabuhanTujuan'
            ])
            ->when($asal, fn($q) => $q->whereHas(
                'jalur.pelabuhanAsal',
                fn($j) => $j->where('lokasi', $asal)
            ))
            ->when($tujuan, fn($q) => $q->whereHas(
                'jalur.pelabuhanTujuan',
                fn($j) => $j->where('lokasi', $tujuan)
            ))
            ->when($kelas, fn($q) => $q->where('kelas', $kelas))
            ->when($tanggal, fn($q) => $q->whereDate('tanggal_berangkat', $tanggal))
            ->orderBy('tanggal_berangkat', 'ASC')
            ->get();

        $pelabuhan = DataPelabuhan::all();

        return view('jadwalpelayaran.lengkap', compact(
            'jadwal', 'pelabuhan',
            'asal', 'tujuan', 'kelas', 'tanggal',
            'dewasa', 'anak', 'bayi'
        ));
    }
}
