<?php

namespace App\Http\Controllers;

use App\Models\JalurPelayaran;
use App\Models\DataPelabuhan;
use Illuminate\Http\Request;

class JalurController extends Controller
{
    // Menampilkan daftar jalur
    public function index()
{
    $jalur = JalurPelayaran::with(['pelabuhanAsal', 'pelabuhanTujuan'])->get();
    return view('jalurpelayaran.index', compact('jalur'));
}


    // Form tambah jalur
    public function create()
    {
        $pelabuhan = DataPelabuhan::all();
        return view('jalurpelayaran.create', compact('pelabuhan'));
    }

    // Simpan jalur baru
    public function store(Request $request)
    {
        $request->validate([
            'id_pelabuhan_asal' => 'required',
            'id_pelabuhan_tujuan' => 'required|different:id_pelabuhan_asal',
            'durasi' => 'required|numeric',
            'jarak'  => 'required|numeric',
        ]);

        JalurPelayaran::create($request->all());

        return redirect()->route('jalurpelayaran.index')->with('success', 'Jalur berhasil ditambahkan.');
    }

    // Edit jalur
    public function edit($id)
{
    $jalur = JalurPelayaran::findOrFail($id);   
    $pelabuhan = DataPelabuhan::all();

    return view('jalurpelayaran.edit', compact('jalur', 'pelabuhan'));
}


    // Update jalur
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pelabuhan_asal' => 'required',
            'id_pelabuhan_tujuan' => 'required|different:id_pelabuhan_asal',
            'durasi' => 'required|numeric',
            'jarak'  => 'required|numeric',
        ]);

        $jalur = JalurPelayaran::findOrFail($id);
        $jalur->update($request->all());

        return redirect()->route('jalurpelayaran.index')->with('success', 'Jalur berhasil diperbarui.');
    }

    // Hapus jalur
    public function destroy($id)
    {
        $jalur = JalurPelayaran::findOrFail($id);
        $jalur->delete();

        return redirect()->route('jalurpelayaran.index')->with('success', 'Jalur berhasil dihapus.');
    }
}
