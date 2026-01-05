<?php

namespace App\Http\Controllers;

use App\Models\DataPelabuhan;
use Illuminate\Http\Request;

class DataPelabuhanController extends Controller
{
    public function index()
    {
        $dataPelabuhan = DataPelabuhan::all();
        return view('datapelabuhan.index', compact('dataPelabuhan'));
    }

    public function create()
    {
        return view('datapelabuhan.create');
    }

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

    public function edit($id)
    {
        $pelabuhan = DataPelabuhan::findOrFail($id);
        return view('datapelabuhan.edit', compact('pelabuhan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelabuhan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'fasilitas_pelabuhan' => 'nullable|string',
        ]);

        $pelabuhan = DataPelabuhan::findOrFail($id);
        $pelabuhan->update([
            'nama_pelabuhan' => $request->nama_pelabuhan,
            'lokasi' => $request->lokasi,
            'fasilitas_pelabuhan' => $request->fasilitas_pelabuhan,
        ]);

        return redirect()->route('datapelabuhan.index')
            ->with('success', 'Pelabuhan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelabuhan = DataPelabuhan::findOrFail($id);
        $pelabuhan->delete();

        return redirect()->route('datapelabuhan.index')
            ->with('success', 'Pelabuhan berhasil dihapus.');
    }

    public function getTujuan($asalId)
    {
        $tujuan = DataPelabuhan::where('id_pelabuhan', '!=', $asalId)->get();
        return response()->json($tujuan);
    }
}
