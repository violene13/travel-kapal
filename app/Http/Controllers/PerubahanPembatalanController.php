<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;

class PerubahanPembatalanController extends Controller
{
    public function index()
    {
        // ambil semua pesanan dengan tipe perubahan atau pembatalan
        $data = Pemesanan::whereIn('tipe', ['perubahan', 'pembatalan'])
                         ->latest()
                         ->get();

        return view('perubahan_pembatalan.index', compact('data'));
    }

    public function process($id)
    {
        $data = Pemesanan::findOrFail($id);
        $data->status = 'Diproses';
        $data->save();

        return redirect()->route('perubahan_pembatalan.index')
                         ->with('success', 'Permintaan berhasil diproses!');
    }

    public function destroy($id)
    {
        $data = Pemesanan::findOrFail($id);
        $data->delete();

        return redirect()->route('perubahan_pembatalan.index')
                         ->with('success', 'Data berhasil dihapus!');
    }
}
