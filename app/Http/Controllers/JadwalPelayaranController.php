<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JadwalPelayaran;
use App\Models\JalurPelayaran;
use App\Models\DataKapal;
use App\Models\Ticketing;

class JadwalPelayaranController extends Controller
{
    // ===============================
    // LIST
    // ===============================
    public function index()
    {
        $jadwal = JadwalPelayaran::with([
            'jalur.pelabuhanAsal',
            'jalur.pelabuhanTujuan',
            'kapal'
        ])->get();

        return view('jadwalpelayaran.index', compact('jadwal'));
    }

    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        $jalur = JalurPelayaran::with(['pelabuhanAsal', 'pelabuhanTujuan'])->get();
        $kapal = DataKapal::all();

        return view('jadwalpelayaran.create', compact('jalur', 'kapal'));
    }

    // ===============================
    // STORE
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'id_jalur'          => 'required|exists:jalur_pelayaran,id_jalur',
            'id_kapal'          => 'required|exists:data_kapal,id_kapal',
            'tanggal_berangkat' => 'required|date',
            'tanggal_tiba'      => 'required|date|after_or_equal:tanggal_berangkat',
            'jam_berangkat'     => 'required',
            'jam_tiba'          => 'required',
        ]);

        JadwalPelayaran::create([
            'id_jalur'          => $request->id_jalur,
            'id_kapal'          => $request->id_kapal,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'tanggal_tiba'      => $request->tanggal_tiba,
            'jam_berangkat'     => $request->jam_berangkat,
            'jam_tiba'          => $request->jam_tiba,
        ]);

        return redirect()
            ->route('jadwalpelayaran.index')
            ->with('success', 'Jadwal pelayaran berhasil ditambahkan.');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $jadwal = JadwalPelayaran::findOrFail($id);
        $jalur  = JalurPelayaran::with(['pelabuhanAsal', 'pelabuhanTujuan'])->get();
        $kapal  = DataKapal::all();

        return view('jadwalpelayaran.edit', compact(
            'jadwal',
            'jalur',
            'kapal'
        ));
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_jalur'          => 'required|exists:jalur_pelayaran,id_jalur',
            'id_kapal'          => 'required|exists:data_kapal,id_kapal',
            'tanggal_berangkat' => 'required|date',
            'tanggal_tiba'      => 'required|date|after_or_equal:tanggal_berangkat',
            'jam_berangkat'     => 'required',
            'jam_tiba'          => 'required',
        ]);

        $jadwal = JadwalPelayaran::findOrFail($id);

        $jadwal->update([
            'id_jalur'          => $request->id_jalur,
            'id_kapal'          => $request->id_kapal,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'tanggal_tiba'      => $request->tanggal_tiba,
            'jam_berangkat'     => $request->jam_berangkat,
            'jam_tiba'          => $request->jam_tiba,
        ]);

        return redirect()
            ->route('jadwalpelayaran.index')
            ->with('success', 'Jadwal pelayaran berhasil diperbarui.');
    }

    // ===============================
    // DELETE
    // ===============================
    public function destroy($id)
    {
        JadwalPelayaran::findOrFail($id)->delete();

        return redirect()
            ->route('jadwalpelayaran.index')
            ->with('success', 'Jadwal pelayaran berhasil dihapus.');
    }

    // ===============================
    // API: KELAS (AMBIL DARI TICKETING)
    // ===============================
    public function getKelas($id_jalur, Request $request)
    {
        $kelas = Ticketing::where('id_jalur', $id_jalur)
            ->where('id_kapal', $request->id_kapal)
            ->distinct()
            ->pluck('kelas');

        return response()->json(['kelas' => $kelas]);
    }

    // ===============================
    // API: KATEGORI
    // ===============================
    public function getKategori($id_jalur, Request $request)
    {
        $kategori = Ticketing::where('id_jalur', $id_jalur)
            ->where('id_kapal', $request->id_kapal)
            ->where('kelas', $request->kelas)
            ->distinct()
            ->pluck('jenis_tiket');

        return response()->json(['kategori' => $kategori]);
    }

    // ===============================
    // API: HARGA
    // ===============================
    public function getHarga($id_jalur, Request $request)
    {
        $ticket = Ticketing::where([
            'id_jalur'    => $id_jalur,
            'id_kapal'    => $request->id_kapal,
            'kelas'       => $request->kelas,
            'jenis_tiket' => $request->jenis_tiket,
        ])->first();

        return response()->json([
            'harga' => (int) ($ticket->harga ?? 0)
        ]);
    }
}
