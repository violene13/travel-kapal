<?php

namespace App\Http\Controllers;

use App\Models\JalurPelayaran;
use App\Models\DataPelabuhan;
use Illuminate\Http\Request;

class JalurController extends Controller
{
    public function index()
    {
        $jalur = JalurPelayaran::with(['pelabuhanAsal', 'pelabuhanTujuan'])->get();
        return view('jalurpelayaran.index', compact('jalur'));
    }

    public function create()
    {
        $pelabuhan = DataPelabuhan::all();
        return view('jalurpelayaran.create', compact('pelabuhan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelabuhan_asal'   => 'required|integer',
            'id_pelabuhan_tujuan' => 'required|integer|different:id_pelabuhan_asal',
            'durasi'              => 'required|string|max:50',
            'jarak'               => 'required|string|max:50',
        ]);

        JalurPelayaran::create([
            'id_pelabuhan_asal'   => $request->id_pelabuhan_asal,
            'id_pelabuhan_tujuan' => $request->id_pelabuhan_tujuan,
            'durasi'              => $request->durasi,
            'jarak'               => $request->jarak,
        ]);

        return redirect()->route('jalurpelayaran.index')->with('success', 'Jalur berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jalur = JalurPelayaran::findOrFail($id);
        $pelabuhan = DataPelabuhan::all();

        return view('jalurpelayaran.edit', compact('jalur', 'pelabuhan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pelabuhan_asal'   => 'required|integer',
            'id_pelabuhan_tujuan' => 'required|integer|different:id_pelabuhan_asal',
            'durasi'              => 'required|string|max:50',
            'jarak'               => 'required|string|max:50',
        ]);

        $jalur = JalurPelayaran::findOrFail($id);
        $jalur->update([
            'id_pelabuhan_asal'   => $request->id_pelabuhan_asal,
            'id_pelabuhan_tujuan' => $request->id_pelabuhan_tujuan,
            'durasi'              => $request->durasi,
            'jarak'               => $request->jarak,
        ]);

        return redirect()->route('jalurpelayaran.index')->with('success', 'Jalur berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jalur = JalurPelayaran::findOrFail($id);
        $jalur->delete();

        return redirect()->route('jalurpelayaran.index')->with('success', 'Jalur berhasil dihapus.');
    }
}
