<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelayaran;
use App\Models\DataKapal;
use App\Models\DataPelabuhan;
use Illuminate\Http\Request;

class JadwalPelayaranController extends Controller
{
    /**
     * Tampilkan daftar semua jadwal pelayaran
     */
    public function index()
    {
        $jadwal = JadwalPelayaran::with(['kapal', 'asalPelabuhan', 'tujuanPelabuhan'])->get();
        return view('jadwalpelayaran.index', compact('jadwal'));
    }

    /**
     * Form tambah jadwal
     */
    public function create()
    {
        $kapal = DataKapal::all();
        $pelabuhan = DataPelabuhan::all(); // untuk dropdown asal & tujuan
        return view('jadwalpelayaran.create', compact('kapal', 'pelabuhan'));
    }

    /**
     * Simpan jadwal baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kapal'           => 'required|exists:data_kapal,id_kapal',
            'id_pelabuhan_asal'  => 'required|exists:data_pelabuhan,id',
            'id_pelabuhan_tujuan'=> 'required|exists:data_pelabuhan,id|different:id_pelabuhan_asal',
            'tanggal_berangkat'  => 'required|date',
            'jam_berangkat'      => 'required',
            'jam_tiba'           => 'required',
            'harga_tiket'        => 'required|numeric',
            'kelas_tiket'        => 'required|string|max:100',
        ]);

        JadwalPelayaran::create($request->all());

        return redirect()->route('jadwalpelayaran.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Form edit jadwal
     */
    public function edit($id)
    {
        $jadwal = JadwalPelayaran::findOrFail($id);
        $kapal = DataKapal::all();
        $pelabuhan = DataPelabuhan::all();
        return view('jadwalpelayaran.edit', compact('jadwal', 'kapal', 'pelabuhan'));
    }

    /**
     * Update jadwal
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kapal'           => 'required|exists:data_kapal,id_kapal',
            'id_pelabuhan_asal'  => 'required|exists:data_pelabuhan,id',
            'id_pelabuhan_tujuan'=> 'required|exists:data_pelabuhan,id|different:id_pelabuhan_asal',
            'tanggal_berangkat'  => 'required|date',
            'jam_berangkat'      => 'required',
            'jam_tiba'           => 'required',
            'harga_tiket'        => 'required|numeric',
            'kelas_tiket'        => 'required|string|max:100',
        ]);

        $jadwal = JadwalPelayaran::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('jadwalpelayaran.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Hapus jadwal
     */
    public function destroy($id)
    {
        $jadwal = JadwalPelayaran::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwalpelayaran.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
