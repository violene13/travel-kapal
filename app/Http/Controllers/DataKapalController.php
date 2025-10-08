<?php

namespace App\Http\Controllers;

use App\Models\DataKapal;
use Illuminate\Http\Request;

class DataKapalController extends Controller
{
    // Menampilkan daftar kapal
    public function index()
    {
        $kapal = DataKapal::all();
        return view('datakapal.index', compact('kapal'));
    }

    // Form tambah kapal
    public function create()
    {
        return view('datakapal.create');
    }

    // Simpan kapal baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kapal' => 'required|string|max:255',
            'jenis_kapal' => 'required|string|max:100',
            'kapasitas'  => 'required|integer|min:1',
        ]);

        DataKapal::create($request->all());

        return redirect()->route('datakapal.index')
                         ->with('success', 'Data kapal berhasil ditambahkan.');
    }

    // Form edit kapal
    public function edit($id)
    {
        $kapal = DataKapal::findOrFail($id);
        return view('datakapal.edit', compact('kapal'));
    }

    // Update kapal
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kapal' => 'required|string|max:255',
            'jenis_kapal' => 'required|string|max:100',
            'kapasitas'  => 'required|integer|min:1',
        ]);

        $kapal = DataKapal::findOrFail($id);
        $kapal->update($request->all());

        return redirect()->route('datakapal.index')
                         ->with('success', 'Data kapal berhasil diperbarui.');
    }

    // Hapus kapal
    public function destroy($id)
    {
        $kapal = DataKapal::findOrFail($id);
        $kapal->delete();

        return redirect()->route('datakapal.index')
                         ->with('success', 'Data kapal berhasil dihapus.');
    }
}
