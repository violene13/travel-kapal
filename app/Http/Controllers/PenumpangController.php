<?php

namespace App\Http\Controllers;

use App\Models\Penumpang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenumpangController extends Controller
{
    /* ==============================
     | ADMIN TRAVEL (PENUMPANG MANUAL)
     ============================== */

    public function index()
    {
        // HANYA penumpang manual (bukan dari web)
        $penumpangs = Penumpang::whereNull('id_user')->get();

        foreach ($penumpangs as $p) {
            $p->usia = $p->tanggal_lahir
                ? Carbon::parse($p->tanggal_lahir)->age
                : '-';
        }

        return view('penumpang.penumpangtravel.index', compact('penumpangs'));
    }

    public function create()
    {
        return view('penumpang.penumpangtravel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penumpang' => 'required|string|max:100',
            'email'          => 'required|email|unique:penumpang,email',
            'no_hp'          => 'nullable|string|max:20',
            'alamat'         => 'nullable|string|max:255',
            'no_ktp'         => 'nullable|string|max:20',
            'gender'         => 'nullable|string|max:10',
            'tanggal_lahir'  => 'nullable|date',
        ]);

        // PAKSA sebagai penumpang manual
        $validated['id_user'] = null;

        Penumpang::create($validated);

        return redirect()->route('penumpang.penumpangtravel.index')
            ->with('success', 'Penumpang berhasil ditambahkan');
    }

    public function edit($id_penumpang)
    {
        $penumpang = Penumpang::findOrFail($id_penumpang);

        // ❌ Travel tidak boleh edit penumpang web
        if ($penumpang->id_user !== null) {
            abort(403, 'Tidak boleh mengakses penumpang dari web');
        }

        return view('penumpang.penumpangtravel.edit', compact('penumpang'));
    }

    public function update(Request $request, $id_penumpang)
    {
        $penumpang = Penumpang::findOrFail($id_penumpang);

        if ($penumpang->id_user !== null) {
            abort(403, 'Tidak boleh mengubah penumpang dari web');
        }

        $validated = $request->validate([
            'nama_penumpang' => 'required|string|max:100',
            'email'          => 'required|email|unique:penumpang,email,' . $id_penumpang . ',id_penumpang',
            'no_hp'          => 'nullable|string|max:20',
            'alamat'         => 'nullable|string|max:255',
            'no_ktp'         => 'nullable|string|max:20',
            'gender'         => 'nullable|string|max:10',
            'tanggal_lahir'  => 'nullable|date',
        ]);

        $penumpang->update($validated);

        return redirect()->route('penumpang.penumpangtravel.index')
            ->with('success', 'Data penumpang berhasil diperbarui');
    }

    public function destroy($id_penumpang)
    {
        $penumpang = Penumpang::findOrFail($id_penumpang);

        if ($penumpang->id_user !== null) {
            abort(403, 'Tidak boleh menghapus penumpang dari web');
        }

        $penumpang->delete();

        return redirect()->route('penumpang.penumpangtravel.index')
            ->with('success', 'Data penumpang berhasil dihapus');
    }

    /* ==============================
     | ADMIN PELAYARAN (SEMUA DATA)
     ============================== */

    public function indexPelayaran()
    {
        $penumpangs = Penumpang::all();

        foreach ($penumpangs as $p) {
            $p->usia = $p->tanggal_lahir
                ? Carbon::parse($p->tanggal_lahir)->age
                : '-';
        }

        return view('penumpang.penumpangpelayaran.index', compact('penumpangs'));
    }

    public function destroyPelayaran($id_penumpang)
    {
        Penumpang::findOrFail($id_penumpang)->delete();

        return redirect()->route('penumpang.penumpangpelayaran.index')
            ->with('success', 'Data penumpang berhasil dihapus');
    }

    /* ==============================
     | PROFIL PENUMPANG (USER WEB)
     ============================== */

    public function profil()
    {
        $penumpang = Penumpang::where('id_user', Auth::id())->firstOrFail();

        return view('penumpang.profil.index', compact('penumpang'));
    }

    public function updateProfil(Request $request)
    {
        $penumpang = Penumpang::where('id_user', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'nama_penumpang' => 'required|string|max:100',
            'no_hp'          => 'nullable|string|max:20',
            'alamat'         => 'nullable|string|max:255',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {

            if ($penumpang->foto && Storage::disk('public')->exists($penumpang->foto)) {
                Storage::disk('public')->delete($penumpang->foto);
            }

            $validated['foto'] = $request->file('foto')
                ->store('penumpang', 'public');
        }

        $penumpang->update($validated);

        return redirect()->route('penumpang.profil')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
