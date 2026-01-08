<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPelayaran;
use App\Models\DataPelabuhan;
use App\Models\Ticketing;

class JadwalPenumpangController extends Controller
{
    // ===============================
    // HALAMAN JADWAL LENGKAP
    // ===============================
    public function jadwalLengkap()
    {
        $jadwal = JadwalPelayaran::with([
                'kapal',
                'jalur.pelabuhanAsal',
                'jalur.pelabuhanTujuan',
            ])
            ->orderBy('tanggal_berangkat', 'ASC')
            ->get();

        // ambil harga ticketing per jadwal
        $jadwal->each(function ($j) {
            $harga = Ticketing::where('id_jalur', $j->id_jalur)
                ->where('id_kapal', $j->id_kapal)
                ->where('kelas', $j->kelas)
                ->pluck('harga', 'jenis_tiket');

            $j->harga_tiket = [
                'dewasa' => (int) ($harga['Dewasa'] ?? 0),
                'anak'   => (int) ($harga['Anak'] ?? 0),
                'bayi'   => (int) ($harga['Bayi'] ?? 0),
            ];
        });

        $pelabuhan = DataPelabuhan::all();

        return view('jadwalpelayaran.lengkap', [
            'jadwal'    => $jadwal,
            'pelabuhan' => $pelabuhan,
            'dewasa'    => 1,
            'anak'      => 0,
            'bayi'      => 0,
        ]);
    }

    // ===============================
    // DETAIL JADWAL
    // ===============================
    public function detail($id)
    {
        $jadwal = JadwalPelayaran::with([
                'kapal',
                'jalur.pelabuhanAsal',
                'jalur.pelabuhanTujuan',
            ])
            ->where('id_jadwal', $id)
            ->firstOrFail();

        $harga = Ticketing::where('id_jalur', $jadwal->id_jalur)
            ->where('id_kapal', $jadwal->id_kapal)
            ->where('kelas', $jadwal->kelas)
            ->pluck('harga', 'jenis_tiket');

        $jadwal->harga_tiket = [
            'dewasa' => (int) ($harga['Dewasa'] ?? 0),
            'anak'   => (int) ($harga['Anak'] ?? 0),
            'bayi'   => (int) ($harga['Bayi'] ?? 0),
        ];

        return view('jadwalpelayaran.detail', compact('jadwal'));
    }

    // ===============================
    // PENCARIAN JADWAL
    // ===============================
    public function cari(Request $request)
    {
        $asal    = $request->asal;
        $tujuan  = $request->tujuan;
        $kelas   = $request->kelas;
        $tanggal = $request->tanggal_berangkat;

        $dewasa = $request->dewasa ?? 1;
        $anak   = $request->anak ?? 0;
        $bayi   = $request->bayi ?? 0;

        $jadwal = JadwalPelayaran::with([
                'kapal',
                'jalur.pelabuhanAsal',
                'jalur.pelabuhanTujuan',
            ])
            ->when($asal, fn ($q) =>
                $q->whereHas('jalur.pelabuhanAsal',
                    fn ($j) => $j->where('lokasi', $asal)
                )
            )
            ->when($tujuan, fn ($q) =>
                $q->whereHas('jalur.pelabuhanTujuan',
                    fn ($j) => $j->where('lokasi', $tujuan)
                )
            )
            ->when($kelas, fn ($q) => $q->where('kelas', $kelas))
            ->when($tanggal, fn ($q) => $q->whereDate('tanggal_berangkat', $tanggal))
            ->orderBy('tanggal_berangkat', 'ASC')
            ->get();

        // inject harga
        $jadwal->each(function ($j) {
            $harga = Ticketing::where('id_jalur', $j->id_jalur)
                ->where('id_kapal', $j->id_kapal)
                ->where('kelas', $j->kelas)
                ->pluck('harga', 'jenis_tiket');

            $j->harga_tiket = [
                'dewasa' => (int) ($harga['dewasa'] ?? 0),
                'anak'   => (int) ($harga['anak'] ?? 0),
                'bayi'   => (int) ($harga['bayi'] ?? 0),
            ];
        });

        $pelabuhan = DataPelabuhan::all();

        return view('jadwalpelayaran.lengkap', compact(
            'jadwal', 'pelabuhan',
            'asal', 'tujuan', 'kelas', 'tanggal',
            'dewasa', 'anak', 'bayi'
        ));
    }
}
