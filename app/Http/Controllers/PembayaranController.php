<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pemesanan;

class PembayaranController extends Controller
{
    /**
     * Tampilkan halaman pembayaran
     */
    public function show($id_pemesanan)
    {
        // =========================
        // Ambil data pemesanan utama
        // =========================
        $pemesanan = DB::table('pemesanan as p')
            ->join('jadwal as j', 'p.id_jadwal', '=', 'j.id_jadwal')
            ->join('kapal as k', 'j.id_kapal', '=', 'k.id_kapal')
            ->join('jalur as jl', 'j.id_jalur', '=', 'jl.id_jalur')
            ->where('p.id_pemesanan', $id_pemesanan)
            ->select(
                'p.id_pemesanan',
                'p.tanggal_pesan',
                'p.status',
                'j.tanggal_berangkat',
                'k.nama_kapal',
                'jl.nama_jalur'
            )
            ->first();

        if (!$pemesanan) {
            abort(404, 'Pemesanan tidak ditemukan');
        }

        // =========================
        // Ambil detail penumpang
        // =========================
        $penumpang = DB::table('pemesanan_penumpang')
            ->where('id_pemesanan', $id_pemesanan)
            ->select(
                'nama_penumpang',
                'jenis_tiket',
                'kelas',
                'harga'
            )
            ->get();

        // =========================
        // Hitung total bayar
        // =========================
        $total = $penumpang->sum('harga');

        return view('pemesanan.pemesananpengguna.pembayaran', compact(
            'pemesanan',
            'penumpang',
            'total'
        ));
    }
}
