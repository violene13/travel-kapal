<?php

namespace App\Http\Controllers;

use App\Models\Penumpang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenumpangController extends Controller
{
    // penumpang travel

    public function index()
    {
        $penumpangs = Penumpang::all();

        foreach ($penumpangs as $p) {
            $p->usia = $p->tanggal_lahir ? Carbon::parse($p->tanggal_lahir)->age : '-';
        }

        $user = auth()->user();
        $backRoute = ($user && $user->role === 'pelayaran')
            ? route('admin.pelayaran.dashboard')
            : route('admin.travel.dashboard');

        return view('penumpang.penumpangtravel.index', compact('penumpangs', 'backRoute'));
    }

    public function create()
    {
        $user = auth()->user();
        $backRoute = ($user && $user->role === 'pelayaran')
            ? route('admin.pelayaran.dashboard')
            : route('admin.travel.dashboard');

        return view('penumpang.penumpangtravel.create', compact('backRoute'));
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

        Penumpang::create($validated);

        $user = auth()->user();

        if ($user && $user->role === 'pelayaran') {
            return redirect()->route('admin.pelayaran.dashboard')
                ->with('success', 'Penumpang berhasil ditambahkan!');
        }

        return redirect()->route('admin.travel.dashboard')
            ->with('success', 'Penumpang berhasil ditambahkan!');
    }

    public function edit($id_penumpang)
    {
        $penumpang = Penumpang::findOrFail($id_penumpang);
        $user = auth()->user();
        $backRoute = ($user && $user->role === 'pelayaran')
            ? route('admin.pelayaran.dashboard')
            : route('admin.travel.dashboard');

        return view('penumpang.penumpangtravel.edit', compact('penumpang', 'backRoute'));
    }

    public function update(Request $request, $id_penumpang)
    {
        $penumpang = Penumpang::findOrFail($id_penumpang);

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

        $user = auth()->user();

        if ($user && $user->role === 'pelayaran') {
            return redirect()->route('admin.pelayaran.dashboard')
                ->with('success', 'Data penumpang berhasil diperbarui!');
        }

        return redirect()->route('admin.travel.dashboard')
            ->with('success', 'Data penumpang berhasil diperbarui!');
    }

    public function destroy($id_penumpang)
    {
        $penumpang = Penumpang::find($id_penumpang);

        if (!$penumpang) {
            return back()->with('error', 'Data penumpang tidak ditemukan!');
        }

        $penumpang->delete();

        $user = auth()->user();

        if ($user && $user->role === 'pelayaran') {
            return redirect()->route('admin.pelayaran.dashboard')
                ->with('success', 'Data penumpang berhasil dihapus!');
        }

        return redirect()->route('admin.travel.dashboard')
            ->with('success', 'Data penumpang berhasil dihapus!');
    }

    // penumang pelayaran

    public function indexPelayaran()
    {
        $penumpangs = Penumpang::all();

        foreach ($penumpangs as $p) {
            $p->usia = $p->tanggal_lahir ? Carbon::parse($p->tanggal_lahir)->age : '-';
        }

        $user = auth()->user();
        $backRoute = ($user && $user->role === 'pelayaran')
            ? route('admin.pelayaran.dashboard')
            : route('admin.travel.dashboard');

        return view('penumpang.penumpangpelayaran.index', compact('penumpangs', 'backRoute'));
    }

    public function destroyPelayaran($id_penumpang)
    {
        $penumpang = Penumpang::find($id_penumpang);

        if (!$penumpang) {
            return redirect()->route('penumpang.penumpangpelayaran.index')
                ->with('error', 'Data penumpang tidak ditemukan!');
        }

        $penumpang->delete();

        return redirect()->route('penumpang.penumpangpelayaran.index')
            ->with('success', 'Data penumpang berhasil dihapus!');
    }

    public function profil()
    {
        $penumpang = Auth::guard('penumpang')->user();
        return view('penumpang.profil.index', compact('penumpang'));
    }

    public function updateProfil(Request $request)
    {
        $penumpang = Auth::guard('penumpang')->user();

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

        $file = $request->file('foto');
        $namaFoto = time() . '_' . $file->getClientOriginalName();

        $path = $file->storeAs(
            'penumpang',
            $namaFoto,
            'public'
        );

        $validated['foto'] = $path;
    }

    $penumpang->update($validated);

    Auth::guard('penumpang')->logout();
    Auth::guard('penumpang')->login($penumpang->fresh());

    return redirect()->route('penumpang.profil')
        ->with('success', 'Profil berhasil diperbarui');

    }   
}