<?php

namespace App\Http\Controllers;
use App\Models\DataPelabuhan;
use App\Models\JadwalPelayaran;

class SealineController extends Controller
{
    public function index()
    {
        // Ambil rute populer
      $rutePopuler = JadwalPelayaran::with([
    'jalur.pelabuhanAsal',
    'jalur.pelabuhanTujuan',
    'kapal',
    'ticketings',
    'ticketingsByKapal'
])
->orderBy('tanggal_berangkat', 'asc')
->take(4)
->get();


        // Ambil semua pelabuhan
        $pelabuhan = DataPelabuhan::all();

        return view('sealine.homes.index', compact('rutePopuler', 'pelabuhan'));
    }
}
