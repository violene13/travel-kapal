<?php

namespace App\Http\Controllers;

use App\Models\DataPelabuhan;
use Illuminate\Http\Request;

class DataPelabuhanController extends Controller
{
    // =====================
    // INDEX: Menampilkan daftar pelabuhan
    // =====================
    public function index()
    {
        $pelabuhan = DataPelabuhan::all();
        return view('datapelabuhan.index', compact('pelabuhan'));
    }

    // =====================
    // CREATE: Form tambah pelabuhan
    // =====================
    public function create()
    {
        return view('datapelabuhan.create');
    }

    // =====================
    // STORE: Simpan data pelabuhan baru
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelabuhan' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
            'fasilitas_pelabuhan' => 'nullable|string',
        ]);

        DataPelabuhan::create([
            'nama_pelabuhan' => $request->nama_pelabuhan,
            'lokasi' => $request->lokasi,
            'fasilitas_pelabuhan' => $request->fasilitas_pelabuhan,
        ]);

        return redirect()->route('datapelabuhan.index')
            ->with('success', 'Data pelabuhan berhasil ditambahkan!');
    }

    // =====================
    // EDIT: Form edit pelabuhan
    // =====================
    public function edit($id)
    {
        $pelabuhan = DataPelabuhan::findOrFail($id);
        return view('datapelabuhan.edit', compact('pelabuhan'));
    }

    // =====================
    // UPDATE: Update data pelabuhan
    // =====================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelabuhan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'fasilitas_pelabuhan' => 'nullable|string',
        ]);

        $pelabuhan = DataPelabuhan::findOrFail($id);
        $pelabuhan->update($request->all());

        return redirect()->route('datapelabuhan.index')
            ->with('success', 'Pelabuhan berhasil diperbarui.');
    }

    // =====================
    // DESTROY: Hapus pelabuhan
    // =====================
    public function destroy($id)
    {
        $pelabuhan = DataPelabuhan::findOrFail($id);
        $pelabuhan->delete();

        return redirect()->route('datapelabuhan.index')
            ->with('success', 'Pelabuhan berhasil dihapus.');
    }

    // =====================
    // EXTRA: Get Tujuan (untuk dropdown AJAX)
    // =====================
    public function getTujuan($asalId)
    {
        $tujuan = DataPelabuhan::where('id', '!=', $asalId)->get();
        return response()->json($tujuan);
    }
}
