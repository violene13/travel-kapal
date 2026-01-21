<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\PemesananPenumpang;
use App\Models\JadwalPelayaran;
use App\Models\Ticketing;
use App\Models\Penumpang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemesananPenumpangController extends Controller
{
    private function getPenumpang()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'penumpang') {
            abort(403, 'Akses ditolak');
        }

        return Penumpang::where('id_user', $user->id)->firstOrFail();
    }

    // ===============================
    // RIWAYAT PEMESANAN
    // ===============================
    public function index()
    {
        $penumpang = $this->getPenumpang();

        $pemesanan = Pemesanan::with([
            'jadwal.kapal',
            'jadwal.jalur.pelabuhanAsal',
            'jadwal.jalur.pelabuhanTujuan',
        ])
            ->where('id_penumpang', $penumpang->id_penumpang)
            ->latest('id_pemesanan')
            ->paginate(10);

        return view('pemesanan.pemesananpengguna.index', compact('pemesanan'));
    }

    // ===============================
    // FORM PEMESANAN
    // ===============================
    public function create($id_jadwal)
    {
        $this->getPenumpang();

        $jadwal = JadwalPelayaran::with(['jalur', 'kapal'])->findOrFail($id_jadwal);

        $ticketings = Ticketing::where('id_jalur', $jadwal->id_jalur)
            ->where('id_kapal', $jadwal->id_kapal)
            ->get()
            ->groupBy('kelas');

        $hargaPerKelas = [];

        foreach ($ticketings as $kelas => $items) {
            foreach ($items as $t) {
                $hargaPerKelas[strtolower($kelas)][strtolower($t->jenis_tiket)] = (int) $t->harga;
            }
        }

        return view('pemesanan.pemesananpengguna.create', compact(
            'jadwal',
            'hargaPerKelas'
        ));
    }

    // ===============================
    // SIMPAN PEMESANAN
    // ===============================
    public function store(Request $request, $id_jadwal)
    {
        $penumpang = $this->getPenumpang();

        if (
            empty($request->dewasa) &&
            empty($request->anak) &&
            empty($request->bayi)
        ) {
            return back()->with('error', 'Minimal 1 penumpang harus diisi');
        }

        $jadwal = JadwalPelayaran::findOrFail($id_jadwal);

        $harga = Ticketing::where('id_jalur', $jadwal->id_jalur)
            ->where('id_kapal', $jadwal->id_kapal)
            ->get()
            ->groupBy(fn ($i) => strtolower($i->kelas))
            ->map(fn ($items) =>
                $items->keyBy(fn ($i) => strtolower($i->jenis_tiket))
            );

        DB::beginTransaction();

        try {

            $totalHarga = 0;

            $pemesanan = Pemesanan::create([
                'id_penumpang'     => $penumpang->id_penumpang,
                'id_jadwal'        => $id_jadwal,
                'id_jalur'         => $jadwal->id_jalur,
                'tanggal_pesan'    => now(),
                'status'           => 'Pending',
                'sumber_pemesanan' => 'user',
            ]);

            foreach (['dewasa', 'anak', 'bayi'] as $tipe) {
                foreach ($request->$tipe ?? [] as $p) {

                    $kelas = strtolower($p['kelas'] ?? 'ekonomi');
                    $hargaTiket = $harga[$kelas][$tipe]->harga ?? 0;

                    PemesananPenumpang::create([
                        'id_pemesanan'     => $pemesanan->id_pemesanan,
                        'id_penumpang'     => $penumpang->id_penumpang,
                        'nama_lengkap'     => $p['nama_lengkap'],
                        'jenis_tiket'      => $tipe,
                        'kelas'            => $kelas,
                        'harga'            => $hargaTiket,
                        'sumber_pemesanan' => 'user',
                    ]);

                    $totalHarga += $hargaTiket;
                }
            }

            $pemesanan->update([
                'total_harga' => $totalHarga
            ]);

            DB::commit();

            return redirect()
                ->route('pemesanan.pemesananpengguna.show', $pemesanan->id_pemesanan)
                ->with('success', 'Pemesanan berhasil dibuat');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan pemesanan');
        }
    }

    // ===============================
    // DETAIL PEMESANAN
    // ===============================
    public function show($id)
    {
        $penumpang = $this->getPenumpang();

        $pemesanan = Pemesanan::with([
            'jadwal.kapal',
            'jadwal.jalur',
            'detailPenumpang'
        ])
            ->where('id_penumpang', $penumpang->id_penumpang)
            ->findOrFail($id);

        return view('pemesanan.pemesananpengguna.show', compact('pemesanan'));
    }

    // ===============================
    // BATAL PEMESANAN
    // ===============================
    public function batal($id)
    {
        $penumpang = $this->getPenumpang();

        $pemesanan = Pemesanan::where('id_pemesanan', $id)
            ->where('id_penumpang', $penumpang->id_penumpang)
            ->where('status', 'Pending')
            ->firstOrFail();

        $pemesanan->update(['status' => 'Cancelled']);

        return back()->with('success', 'Pemesanan berhasil dibatalkan.');
    }

    // ===============================
    // HAPUS PEMESANAN
    // ===============================
    public function hapus($id)
    {
        $penumpang = $this->getPenumpang();

        $pemesanan = Pemesanan::where('id_pemesanan', $id)
            ->where('id_penumpang', $penumpang->id_penumpang)
            ->firstOrFail();

        if ($pemesanan->status !== 'Cancelled') {
            return back()->with('error', 'Hanya pemesanan yang dibatalkan yang bisa dihapus.');
        }

        $pemesanan->delete();

        return redirect()
            ->route('pemesanan.pemesananpengguna.index')
            ->with('success', 'Pemesanan berhasil dihapus.');
    }

    public function eticket($id)
{
    $penumpang = $this->getPenumpang();

    $pemesanan = Pemesanan::with([
        'jadwal.kapal',
        'jadwal.jalur.pelabuhanAsal',
        'jadwal.jalur.pelabuhanTujuan',
        'detailPenumpang'
    ])
    ->where('id_pemesanan', $id)
    ->where('id_penumpang', $penumpang->id_penumpang)
    ->where('status', 'confirmed')
    ->firstOrFail();

    return view('pemesanan.pemesananpengguna.eticket', compact('pemesanan'));
}

}
