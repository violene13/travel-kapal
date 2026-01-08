<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\JadwalPelayaran;
use App\Models\Ticketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananPenumpangController extends Controller
{
    
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

    public function create(Request $request, $id_jadwal)
    {
        $jadwal = JadwalPelayaran::with(['kapal', 'jalur'])->findOrFail($id_jadwal);

    $hargaRaw = Ticketing::where('id_kapal', $jadwal->id_kapal)
    ->where('id_jalur', $jadwal->id_jalur)
    ->where('kelas', 'Ekonomi')
    ->pluck('harga', 'jenis_tiket');

   $hargaRaw = Ticketing::where('id_jalur', $jadwal->id_jalur)
    ->where('kelas', 'Ekonomi')
    ->pluck('harga', 'jenis_tiket');

$harga = [
    'dewasa' => (int) ($hargaRaw['dewasa'] ?? 0),
    'anak'   => (int) ($hargaRaw['anak'] ?? 0),
    'bayi'   => (int) ($hargaRaw['bayi'] ?? 0),
];


        return view('pemesanan.pemesananpengguna.create', [
            'jadwal' => $jadwal,
            'dewasa' => (int) $request->dewasa,
            'anak'   => (int) $request->anak,
            'bayi'   => (int) $request->bayi,
            'harga'  => $harga
        ]);
    }

  public function store(Request $request, $id_jadwal)
{
    $user = Auth::guard('penumpang')->user();
    if (!$user) {
        return redirect()->route('sealine.homes.index')
            ->with('error', 'Silakan login terlebih dahulu!');
    }

    $jadwal = JadwalPelayaran::findOrFail($id_jadwal);
    $id_jalur = $jadwal->id_jalur;

    $jumlahDewasa = count($request->dewasa ?? []);
    $jumlahAnak   = count($request->anak ?? []);
    $jumlahBayi   = count($request->bayi ?? []);

    $hargaDewasa = Ticketing::where('id_jalur', $id_jalur)
    ->where('jenis_tiket', 'dewasa')
    ->where('kelas', 'Ekonomi')
    ->value('harga') ?? 0;

$hargaAnak = Ticketing::where('id_jalur', $id_jalur)
    ->where('jenis_tiket', 'anak')
    ->where('kelas', 'Ekonomi')
    ->value('harga') ?? 0;

$hargaBayi = Ticketing::where('id_jalur', $id_jalur)
    ->where('jenis_tiket', 'bayi')
    ->where('kelas', 'Ekonomi')
    ->value('harga') ?? 0;


    $totalHarga =
        ($jumlahDewasa * $hargaDewasa) +
        ($jumlahAnak   * $hargaAnak) +
        ($jumlahBayi   * $hargaBayi);

    $pemesanan = Pemesanan::create([
        'id_penumpang'  => $user->id_penumpang,
        'id_jadwal'     => $id_jadwal,
        'id_jalur'      => $id_jalur,
        'tanggal_pesan' => now(),
        'total_harga'   => $totalHarga,
        'status'        => 'Pending',
    ]);

    return redirect()
        ->route('pemesanan.pemesananpengguna.show', $pemesanan->id_pemesanan)
        ->with('success', 'Pemesanan berhasil dibuat. Silakan lanjutkan pembayaran.');
}


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
