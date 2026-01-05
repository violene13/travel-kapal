<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\JadwalPelayaran;
use App\Models\Ticketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananPenumpangController extends Controller
{
    // =====================================================================
    // LIST PEMESANAN PENUMPANG
    // =====================================================================
    public function index()
    {
        $user = Auth::guard('penumpang')->user();
        if (!$user) {
            return redirect()->route('sealine.homes.index')
                ->with('error', 'Silakan login terlebih dahulu!');
        }

        $pemesanan = Pemesanan::with(['jadwal.kapal', 'jadwal.jalur'])
            ->where('id_penumpang', $user->id_penumpang)
            ->latest('id_pemesanan')
            ->paginate(10);

        return view('pemesanan.pemesananpengguna.index', compact('pemesanan'));
    }

    // =====================================================================
    // FORM PEMESANAN (JUMLAH DEWASA / ANAK / BAYI)
    // =====================================================================
   

public function create(Request $request, $id_jadwal)
{
    $jadwal = JadwalPelayaran::with(['kapal', 'jalur'])->findOrFail($id_jadwal);

    $harga = Ticketing::where('id_jadwal', $id_jadwal)
        ->pluck('harga', 'tipe_penumpang');

    return view('pemesanan.pemesananpengguna.create', [
        'jadwal' => $jadwal,
        'dewasa' => (int) $request->dewasa,
        'anak'   => (int) $request->anak,
        'bayi'   => (int) $request->bayi,
        'harga'  => $harga
    ]);
}

// =====================================================================
    // SIMPAN PEMESANAN
    // =====================================================================
   public function store(Request $request, $id_jadwal)
{
    $user = Auth::guard('penumpang')->user();
    if (!$user) {
        return redirect()->route('sealine.homes.index')
            ->with('error', 'Silakan login terlebih dahulu!');
    }

    // Hitung jumlah penumpang
    $jumlahDewasa = count($request->dewasa ?? []);
    $jumlahAnak   = count($request->anak ?? []);
    $jumlahBayi   = count($request->bayi ?? []);

    // Ambil harga dari tabel ticketing
    $hargaDewasa = Ticketing::where('id_jadwal', $id_jadwal)
        ->where('tipe_penumpang', 'dewasa')
        ->value('harga') ?? 0;

    $hargaAnak = Ticketing::where('id_jadwal', $id_jadwal)
        ->where('tipe_penumpang', 'anak')
        ->value('harga') ?? 0;

    $hargaBayi = Ticketing::where('id_jadwal', $id_jadwal)
        ->where('tipe_penumpang', 'bayi')
        ->value('harga') ?? 0;

    // Hitung total harga (VALID & AMAN)
    $totalHarga =
        ($jumlahDewasa * $hargaDewasa) +
        ($jumlahAnak   * $hargaAnak) +
        ($jumlahBayi   * $hargaBayi);

    $pemesanan = Pemesanan::create([
        'id_penumpang'  => $user->id_penumpang,
        'id_jadwal'     => $id_jadwal,
        'tanggal_pesan' => now(),
        'total_harga'   => $totalHarga,
        'status'        => 'Pending',
    ]);

    return redirect()
        ->route('pemesanan.pemesananpengguna.show', $pemesanan->id_pemesanan)
        ->with('success', 'Pemesanan berhasil dibuat. Silakan lanjutkan pembayaran.');
}

    // =====================================================================
    // DETAIL PEMESANAN PENUMPANG
    // =====================================================================
    public function show($id)
    {
        $user = Auth::guard('penumpang')->user();
        if (!$user) {
            return redirect()->route('sealine.homes.index')
                ->with('error', 'Silakan login terlebih dahulu!');
        }

        $pemesanan = Pemesanan::with(['jadwal.kapal', 'jadwal.jalur'])
            ->where('id_penumpang', $user->id_penumpang)
            ->findOrFail($id);

        return view('pemesanan.pemesananpengguna.show', compact('pemesanan'));
    }
}
