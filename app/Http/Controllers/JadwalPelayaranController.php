<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPelayaran;
use App\Models\JalurPelayaran;
use App\Models\DataKapal;
use App\Models\Ticketing;

class JadwalPelayaranController extends Controller
{
    // ===============================
    // LIST JADWAL
    // ===============================
        public function index()
        {
           $jadwal = JadwalPelayaran::with([
            'jalur.pelabuhanAsal',
            'jalur.pelabuhanTujuan',
            'kapal',
        ])->get();


    return view('jadwalpelayaran.index', compact('jadwal'));
}

    // ===============================
    // FORM TAMBAH JADWAL
    // ===============================
    public function create()
    {
        $jalur = JalurPelayaran::with(['pelabuhanAsal', 'pelabuhanTujuan'])->get();
        $kapal = DataKapal::all();

        return view('jadwalpelayaran.create', compact('jalur', 'kapal'));
    }

    // ===============================
    // SIMPAN JADWAL
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'id_jalur' => 'required|exists:jalur_pelayaran,id_jalur',
            'id_kapal' => 'required|exists:data_kapal,id_kapal',
            'tanggal_berangkat' => 'required|date',
            'jam_berangkat' => 'required',
            'jam_tiba' => 'required',
            'kelas' => 'required|string',
        ]);

        JadwalPelayaran::create([
            'id_jalur' => $request->id_jalur,
            'id_kapal' => $request->id_kapal,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'jam_berangkat' => $request->jam_berangkat,
            'jam_tiba' => $request->jam_tiba,
            'kelas' => $request->kelas,
        ]);

        return redirect()
            ->route('jadwalpelayaran.index')
            ->with('success', 'Jadwal pelayaran berhasil ditambahkan.');
    }

    // ===============================
    // FORM EDIT JADWAL
    // ===============================
    public function edit($id_jadwal)
    {
        $jadwal = JadwalPelayaran::findOrFail($id_jadwal);
        $jalur  = JalurPelayaran::with(['pelabuhanAsal', 'pelabuhanTujuan'])->get();
        $kapal  = DataKapal::all();

        // kelas berdasarkan jalur + kapal
        $kelas = Ticketing::where('id_jalur', $jadwal->id_jalur)
            ->where('id_kapal', $jadwal->id_kapal)
            ->distinct()
            ->pluck('kelas');

        return view('jadwalpelayaran.edit', compact('jadwal', 'jalur', 'kapal', 'kelas'));
    }

    // ===============================
    // UPDATE JADWAL
    // ===============================
    public function update(Request $request, $id_jadwal)
    {
        $request->validate([
            'id_jalur' => 'required|exists:jalur_pelayaran,id_jalur',
            'id_kapal' => 'required|exists:data_kapal,id_kapal',
            'tanggal_berangkat' => 'required|date',
            'jam_berangkat' => 'required',
            'jam_tiba' => 'required',
            'kelas' => 'required|string',


        ]);

        $jadwal = JadwalPelayaran::findOrFail($id_jadwal);

        $jadwal->update([
            'id_jalur' => $request->id_jalur,
            'id_kapal' => $request->id_kapal,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'jam_berangkat' => $request->jam_berangkat,
            'jam_tiba' => $request->jam_tiba,
            'kelas' => $request->kelas,

        ]);

        return redirect()
            ->route('jadwalpelayaran.index')
            ->with('success', 'Jadwal pelayaran berhasil diperbarui.');
    }

    // ===============================
    // HAPUS JADWAL
    // ===============================
    public function destroy($id_jadwal)
    {
        JadwalPelayaran::findOrFail($id_jadwal)->delete();

        return redirect()
            ->route('jadwalpelayaran.index')
            ->with('success', 'Jadwal pelayaran berhasil dihapus.');
    }

    // ===============================
    // API: AMBIL KELAS
    // ===============================
    public function getKelas($id_jalur, Request $request)
    {
        $kapalId = $request->query('id_kapal');

        $kelas = Ticketing::where('id_jalur', $id_jalur)
            ->when($kapalId, fn ($q) => $q->where('id_kapal', $kapalId))
            ->distinct()
            ->pluck('kelas');

        return response()->json([
            'kelas' => $kelas
        ]);
    }

    // ===============================
    // API: AMBIL KATEGORI (JENIS TIKET)
    // ===============================
    public function getKategori($id_jalur, Request $request)
    {
        $kapalId = $request->query('id_kapal');
        $kelas   = $request->query('kelas');

        $kategori = Ticketing::where('id_jalur', $id_jalur)
            ->when($kapalId, fn ($q) => $q->where('id_kapal', $kapalId))
            ->when($kelas, fn ($q) => $q->where('kelas', $kelas))
            ->distinct()
            ->pluck('jenis_tiket');

        return response()->json([
            'kategori' => $kategori
        ]);
    }

   // ===============================
// API: AMBIL HARGA
// ===============================
public function getHarga($id_jalur, Request $request)
{
    $kapalId    = $request->query('id_kapal');
    $kelas      = $request->query('kelas');
    $jenisTiket = $request->query('jenis_tiket');

    // validasi parameter wajib
    if (!$kelas || !$jenisTiket) {
        return response()->json([
            'harga' => 0,
            'error' => 'Parameter tidak lengkap'
        ], 400);
    }

    $ticket = Ticketing::where('id_jalur', $id_jalur)
        ->where('kelas', $kelas)
        ->where('jenis_tiket', $jenisTiket)
        ->when($kapalId, function ($q) use ($kapalId) {
            $q->where('id_kapal', $kapalId);
        })
        ->first();

    return response()->json([
        'harga' => (float) ($ticket->harga ?? 0)
    ]);
}

}
