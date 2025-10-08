<?php

namespace App\Http\Controllers;

use App\Models\Penumpang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenumpangController extends Controller
{
    // Menampilkan daftar penumpang
    public function index()
    {
        $penumpangs = Penumpang::all();

        // Hitung usia otomatis
        foreach ($penumpangs as $p) {
            if (!empty($p->tanggal_lahir)) {
                $p->usia = Carbon::parse($p->tanggal_lahir)->age;
            } else {
                $p->usia = '-';
            }
        }

        return view('penumpang.index', compact('penumpangs'));
    }

    // Hapus penumpang
    public function destroy($id)
    {
        $penumpang = Penumpang::find($id);

        if (!$penumpang) {
            return redirect()->route('penumpang.index')->with('error', 'Data penumpang tidak ditemukan!');
        }

        $penumpang->delete();

        return redirect()->route('penumpang.index')->with('success', 'Data penumpang berhasil dihapus!');
    }
}
