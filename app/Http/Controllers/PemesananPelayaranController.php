<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananPelayaranController extends Controller
{
    public function index(Request $request)
    {
        $this->validatePelayaran();

        $query = Pemesanan::with(['penumpang', 'jadwal.kapal', 'jadwal.jalur']);

        // Admin pel lihat data pemesanan
        if ($request->search) {
            $query->whereHas('penumpang', function ($q) use ($request) {
                $q->where('nama_penumpang', 'like', "%{$request->search}%")
                  ->orWhere('no_hp', 'like', "%{$request->search}%");
            });
        }

        $pemesanan = $query->orderByDesc('id_pemesanan')->paginate(10);

        return view('pemesanan.pemesananpelayaran.index', compact('pemesanan'));
    }

    public function show($id)
    {
        $this->validatePelayaran();

        $pemesanan = Pemesanan::with(['penumpang', 'jadwal.kapal', 'jadwal.jalur'])
            ->findOrFail($id);

        return view('pemesanan.pemesananpelayaran.show', compact('pemesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Cancelled'
        ]);

        $user = Auth::user();
        if ($user->role !== 'admin_pelayaran') {
            return back()->with('error', 'Akses ditolak!');
        }

        Pemesanan::findOrFail($id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    private function validatePelayaran()
    {
        if (Auth::user()->role !== 'admin_pelayaran') {
            abort(403, 'Akses ditolak (pelayaran only)');
        }
    }
}
