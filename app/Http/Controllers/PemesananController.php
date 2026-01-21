<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\PemesananPenumpang;
use App\Models\Penumpang;
use App\Models\JadwalPelayaran;
use App\Models\Ticketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    /* =========================
        INDEX
    ========================== */
    public function index(Request $request)
{
    $this->validateTravel();

    $query = Pemesanan::with([
        'penumpang',
        'jadwal.kapal',
        'jadwal.jalur',
        'detailPenumpang'
    ])
    ->where('sumber_pemesanan', 'admin_travel') // 🔥 INI KUNCI UTAMA
    ->where('id_admin_travel', Auth::user()->id_admin_travel);

    if ($request->search) {
        $query->whereHas('penumpang', function ($q) use ($request) {
            $q->where('nama_penumpang', 'like', "%{$request->search}%")
              ->orWhere('no_hp', 'like', "%{$request->search}%");
        });
    }

    $pemesanan = $query
        ->orderByDesc('id_pemesanan')
        ->paginate(10);

    return view('pemesanan.pemesanantravel.index', compact('pemesanan'));
}

    /* =========================
        CREATE
    ========================== */
    public function create()
    {
        $this->validateTravel();

        $jadwals = JadwalPelayaran::with(['kapal', 'jalur'])->get();

        // kelas tiket dinamis
        $kelasTiket = Ticketing::select('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view(
            'pemesanan.pemesanantravel.create',
            compact('jadwals', 'kelasTiket')
        );
    }

    /* =========================
        STORE
    ========================== */
public function store(Request $request)
{
    $this->validateTravel();

    if (
        empty($request->dewasa) &&
        empty($request->anak) &&
        empty($request->bayi)
    ) {
        return back()->with('error', 'Minimal 1 penumpang harus diisi');
    }

    DB::beginTransaction();

    try {
        // ================= JADWAL =================
        $jadwal = JadwalPelayaran::findOrFail($request->id_jadwal);

        // ================= HARGA TIKET =================
        $hargaMap = Ticketing::where('id_jalur', $jadwal->id_jalur)
            ->where('id_kapal', $jadwal->id_kapal)
            ->get()
            ->groupBy(fn ($i) => strtolower($i->kelas))
            ->map(fn ($items) =>
                $items->keyBy(fn ($i) => strtolower($i->jenis_tiket))
            );

       // ================= PEMESAN UTAMA =================
       $pemesan = Penumpang::create([
            'nama_penumpang' => $request->pemesan['nama_penumpang'],
            'no_hp'          => $request->pemesan['no_hp'] ?? '-',
            'no_ktp'         => $request->pemesan['no_ktp'] ?? '-',
            'alamat'         => $request->pemesan['alamat'] ?? '-', // ✅ TAMBAH
        ]);




                $pemesanan = Pemesanan::create([
            'sumber_pemesanan' => 'admin_travel',
            'id_penumpang'     => $pemesan->id_penumpang, // ✅ BENAR
            'id_admin_travel'  => Auth::user()->id_admin_travel,
            'id_jadwal'        => $jadwal->id_jadwal,
            'tanggal_pesan'    => now(),
            'status'           => 'Pending',
            'total_harga'      => 0,
        ]);


        // ================= DETAIL PENUMPANG =================
        $totalHarga = 0;

        foreach (['dewasa','anak','bayi'] as $tipe) {
            foreach ($request->$tipe ?? [] as $p) {

              $penumpang = Penumpang::create([
                    'nama_penumpang' => $p['nama_lengkap'],
                    'no_hp' => '-',
                    'no_ktp' => '-',
                    'alamat' => '-', 
                ]);

                $kelas = strtolower($p['kelas']);
                $harga = $hargaMap[$kelas][$tipe]->harga ?? 0;

                PemesananPenumpang::create([
                    'id_pemesanan' => $pemesanan->id_pemesanan,
                    'id_penumpang' => $penumpang->id_penumpang,
                    'nama_lengkap' => $p['nama_lengkap'],
                    'jenis_tiket'  => $tipe,
                    'kelas'        => $kelas,
                    'harga'        => $harga,
                ]);

                $totalHarga += $harga;
            }
        }

        // ================= UPDATE TOTAL =================
        $pemesanan->update([
            'total_harga' => $totalHarga
        ]);

        DB::commit();

        return redirect()
            ->route('pemesanan.pemesanantravel.index')
            ->with('success', 'Pemesanan travel berhasil dibuat');

    } catch (\Throwable $e) {
        DB::rollBack();
        dd($e->getMessage()); // AKTIFKAN SEKALI UNTUK DEBUG
    }
}
    /* =========================
        SHOW
    ========================== */
    public function show($id)
    {
        $pemesanan = Pemesanan::with([
            'penumpang',
            'jadwal.kapal',
            'jadwal.jalur.pelabuhanAsal',
            'jadwal.jalur.pelabuhanTujuan',
            'detailPenumpang'
        ])->findOrFail($id);

        return view('pemesanan.pemesanantravel.show', compact('pemesanan'));
    }

    /* =========================
        DESTROY
    ========================== */
    public function destroy($id)
    {
        $this->validateTravel();

        Pemesanan::findOrFail($id)->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    /* =========================
        VALIDASI ROLE
    ========================== */
    private function validateTravel()
    {
        if (Auth::user()->role !== 'admin_travel') {
            abort(403, 'Akses ditolak');
        }
    }
}
