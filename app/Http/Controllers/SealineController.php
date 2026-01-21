<?php

namespace App\Http\Controllers;

use App\Models\DataPelabuhan;
use App\Models\JadwalPelayaran;
use App\Models\Ticketing;

class SealineController extends Controller
{
    public function index()
    {
        $defaultKelas = 'Ekonomi';

        $rutePopuler = JadwalPelayaran::with([
            'jalur.pelabuhanAsal',
            'jalur.pelabuhanTujuan',
            'kapal'
        ])
        ->orderBy('tanggal_berangkat', 'asc')
        ->take(4)
        ->get();

        // 🔥 SAMAKAN DENGAN JADWAL LENGKAP
        foreach ($rutePopuler as $rute) {

            $harga = Ticketing::where('id_jalur', $rute->id_jalur)
                ->where('id_kapal', $rute->id_kapal)
                ->whereRaw('LOWER(kelas) = ?', [strtolower($defaultKelas)])
                ->whereRaw('LOWER(jenis_tiket) = ?', ['dewasa'])
                ->value('harga');

            $rute->kelas = $defaultKelas;
            $rute->harga = (int) ($harga ?? 0);
        }

        $pelabuhan = DataPelabuhan::all();

        return view('sealine.homes.index', compact(
            'rutePopuler',
            'pelabuhan'
        ));
    }
}
