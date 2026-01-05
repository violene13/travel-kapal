<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPelayaran;
use App\Models\JalurPelayaran;
use App\Models\DataKapal;
use App\Models\DataPelabuhan;
use App\Models\Ticketing;

class JadwalPelayaranController extends Controller
{
    // INDEX (Admin)
    public function index()
    {
        $jadwal = JadwalPelayaran::with([
            'jalur.pelabuhanAsal',
            'jalur.pelabuhanTujuan',
            'kapal',
            'ticketings'
        ])->get();

        return view('jadwalpelayaran.index', compact('jadwal'));
    }

    // CREATE
    public function create()
    {
        $jalur = JalurPelayaran::with(['pelabuhanAsal', 'pelabuhanTujuan'])->get();
        $kapal = DataKapal::all();

        return view('jadwalpelayaran.create', compact('jalur', 'kapal'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'id_jalur' => 'required|exists:jalur_pelayaran,id_jalur',
            'id_kapal' => 'required|exists:data_kapal,id_kapal',
            'tanggal_berangkat' => 'required|date',
            'jam_berangkat' => 'required',
            'jam_tiba' => 'required',
            'kelas' => 'required|string',
            'harga' => 'required|numeric|min:0',
        ]);

        JadwalPelayaran::create($request->only([
            'id_jalur',
            'id_kapal',
            'tanggal_berangkat',
            'jam_berangkat',
            'jam_tiba',
            'kelas',
            'harga'
        ]));

        return redirect()->route('jadwalpelayaran.index')
                        ->with('success', 'Jadwal pelayaran berhasil ditambahkan.');
    }

    // EDIT
    public function edit($id_jadwal)
    {
        $jadwal = JadwalPelayaran::findOrFail($id_jadwal);
        $jalur = JalurPelayaran::with(['pelabuhanAsal', 'pelabuhanTujuan'])->get();
        $kapal = DataKapal::all();

        $kelas = Ticketing::where('id_jalur', $jadwal->id_jalur)
                        ->where('id_kapal', $jadwal->id_kapal)
                        ->distinct()
                        ->pluck('kelas');

        return view('jadwalpelayaran.edit', compact('jadwal', 'jalur', 'kapal', 'kelas'));
    }

    // UPDATE
    public function update(Request $request, $id_jadwal)
    {
        $request->validate([
            'id_jalur' => 'required|exists:jalur_pelayaran,id_jalur',
            'id_kapal' => 'required|exists:data_kapal,id_kapal',
            'tanggal_berangkat' => 'required|date',
            'jam_berangkat' => 'required',
            'jam_tiba' => 'required',
            'kelas' => 'required|string',
            'harga' => 'required|numeric|min:0',
        ]);

        $jadwal = JadwalPelayaran::findOrFail($id_jadwal);

        $jadwal->update($request->only([
            'id_jalur',
            'id_kapal',
            'tanggal_berangkat',
            'jam_berangkat',
            'jam_tiba',
            'kelas',
            'harga'
        ]));

        return redirect()->route('jadwalpelayaran.index')
                        ->with('success', 'Jadwal pelayaran berhasil diperbarui.');
    }

    // DESTROY
    public function destroy($id_jadwal)
    {
        $jadwal = JadwalPelayaran::findOrFail($id_jadwal);
        $jadwal->delete();

        return redirect()->route('jadwalpelayaran.index')
                        ->with('success', 'Jadwal pelayaran berhasil dihapus.');
    }

    // AJAX GET KELAS
    public function getKelas($id_jalur, Request $request)
    {
        $kapalId = $request->query('id_kapal');

        $kelas = Ticketing::where('id_jalur', $id_jalur)
                        ->when($kapalId, fn($q) => $q->where('id_kapal', $kapalId))
                        ->distinct()
                        ->pluck('kelas');

        return response()->json(['kelas' => $kelas]);
    }

    // AJAX GET HARGA
    public function getHarga($id_jalur, $kelas, Request $request)
    {
        $kapalId = $request->query('id_kapal');

        $ticket = Ticketing::where('id_jalur', $id_jalur)
                        ->where('kelas', $kelas)
                        ->when($kapalId, fn($q) => $q->where('id_kapal', $kapalId))
                        ->first();

        return response()->json([
            'harga' => (float) ($ticket->harga ?? 0)
        ]);
    }
}
