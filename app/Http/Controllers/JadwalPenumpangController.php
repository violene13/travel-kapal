<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPelayaran;
use App\Models\DataPelabuhan;
use App\Models\Ticketing;
use Carbon\Carbon;

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

        // DEFAULT PILIHAN
        $defaultKelas = 'Ekonomi';
        $defaultJenis = 'dewasa';

        $jadwal->each(function ($j) use ($defaultKelas, $defaultJenis) {

            $ticket = Ticketing::where('id_jalur', $j->id_jalur)
                ->where('id_kapal', $j->id_kapal)
                ->whereRaw('LOWER(kelas) = ?', [strtolower($defaultKelas)])
                ->whereRaw('LOWER(jenis_tiket) = ?', [$defaultJenis])
                ->first();

            $j->kelas       = $defaultKelas;
            $j->jenis_tiket = $defaultJenis;
            $j->harga       = (int) ($ticket->harga ?? 0);
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

public function detail($id)
{
    // ===============================
    // AMBIL JADWAL + RELASI
    // ===============================
    $jadwal = JadwalPelayaran::with([
        'kapal',
        'jalur.pelabuhanAsal',
        'jalur.pelabuhanTujuan',
    ])
    ->where('id_jadwal', $id)
    ->firstOrFail();

    // ===============================
    // AMBIL HARGA TICKETING
    // ===============================
    $ticketings = Ticketing::where('id_jalur', $jadwal->id_jalur)
        ->where('id_kapal', $jadwal->id_kapal)
        ->get();

    /**
     * FORMAT:
     * [
     *   'Ekonomi' => ['dewasa'=>150000,'anak'=>100000,'bayi'=>25000],
     *   'Bisnis'  => ['dewasa'=>250000,'anak'=>175000,'bayi'=>50000]
     * ]
     */
    $hargaPerKelas = [];

    foreach ($ticketings as $t) {
        $kelas = ucfirst(strtolower($t->kelas));
        $jenis = strtolower($t->jenis_tiket);

        $hargaPerKelas[$kelas][$jenis] = (int) $t->harga;
    }

    // ===============================
    // HITUNG DURASI REAL (AKURAT)
    // ===============================
    $berangkat = Carbon::parse(
        $jadwal->tanggal_berangkat . ' ' . $jadwal->jam_berangkat
    );

    $tiba = Carbon::parse(
        $jadwal->tanggal_tiba . ' ' . $jadwal->jam_tiba
    );

    // JIKA TIBA < BERANGKAT (LINTAS HARI)
    if ($tiba->lessThan($berangkat)) {
        $tiba->addDay();
    }

    $durasiMenit = $berangkat->diffInMinutes($tiba);

    $jam   = intdiv($durasiMenit, 60);
    $menit = $durasiMenit % 60;

    $jadwal->durasi = $menit > 0
        ? "{$jam} Jam {$menit} Menit"
        : "{$jam} Jam";

    return view('jadwalpelayaran.detail', compact(
        'jadwal',
        'hargaPerKelas'
    ));
}


    // ===============================
    // PENCARIAN JADWAL
    // ===============================
    public function cari(Request $request)
    {
        $asal    = $request->asal;
        $tujuan  = $request->tujuan;
        $tanggal = $request->tanggal_berangkat;

        $kelas = $request->kelas ?? 'Ekonomi';

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
            ->when($tanggal, fn ($q) =>
                $q->whereDate('tanggal_berangkat', $tanggal)
            )
            ->orderBy('tanggal_berangkat', 'ASC')
            ->get();

        $jadwal->each(function ($j) use ($kelas) {

            $harga = Ticketing::where('id_jalur', $j->id_jalur)
                ->where('id_kapal', $j->id_kapal)
                ->whereRaw('LOWER(kelas) = ?', [strtolower($kelas)])
                ->pluck('harga', 'jenis_tiket');

            $j->kelas = $kelas;

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
