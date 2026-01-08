<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Penumpang;
use App\Models\JadwalPelayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{

    public function index(Request $request)
    {
        $this->validateTravel();

        $query = Pemesanan::with(['penumpang', 'jadwal.kapal', 'jadwal.jalur'])
            ->where('id_admin_travel', Auth::id());

        if ($request->search) {
            $query->whereHas('penumpang', function ($q) use ($request) {
                $q->where('nama_penumpang', 'like', "%{$request->search}%")
                  ->orWhere('no_hp', 'like', "%{$request->search}%");
            });
        }

        $pemesanan = $query->orderByDesc('id_pemesanan')->paginate(10);

        return view($this->viewPath() . '.index', compact('pemesanan'));
    }

    public function create()
    {
        $this->validateTravel();

        $jadwals = JadwalPelayaran::with(['kapal', 'jalur'])
            ->orderBy('tanggal_berangkat', 'asc')
            ->get();

        return view($this->viewPath() . '.create', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $this->validateTravel();

        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_pelayaran,id_jadwal',
            'penumpang.nama_penumpang' => 'required|string|max:255',
            'penumpang.no_hp' => 'required',
        ]);

        $penumpang = Penumpang::firstOrCreate(
            ['nama_penumpang' => $request->penumpang['nama_penumpang']],
            [
                'no_hp' => $request->penumpang['no_hp'],
                'no_ktp' => $request->penumpang['no_ktp'] ?? '-',
                'email' => $request->penumpang['email'] ?? null,
                'alamat' => $request->penumpang['alamat'] ?? null,
                'gender' => $request->penumpang['gender'] ?? null,
                'tanggal_lahir' => $request->penumpang['tanggal_lahir'] ?? null,
            ]
        );

        Pemesanan::create([
            'id_jadwal' => $request->id_jadwal,
            'id_penumpang' => $penumpang->id_penumpang,
            'id_admin_travel' => Auth::id(),
            'tanggal_pesan' => now(),
            'status' => 'Pending',
        ]);

        return redirect()->route('pemesanan.pemesanantravel.index')
            ->with('success', 'Pemesanan berhasil dibuat!');
    }

   public function edit($id)
{
    $this->validateTravel();

    $pemesanan = Pemesanan::with(['jadwal', 'penumpang'])
        ->where('id_pemesanan', $id)
        ->firstOrFail();

    $jadwals = JadwalPelayaran::with(['kapal', 'jalur'])->get();
    $penumpang = Penumpang::all();

    return view($this->viewPath() . '.edit', compact('pemesanan', 'jadwals', 'penumpang'));
}


  public function update(Request $request, $id)
{
    $this->validateTravel();

    $request->validate([
        'id_penumpang' => 'required|exists:penumpang,id_penumpang',
        'id_jadwal'    => 'required|exists:jadwal_pelayaran,id_jadwal',
        'status'       => 'required|in:Pending,Confirmed,Cancelled',
        'tanggal_pesan'=> 'required|date'
    ]);

    $pemesanan = Pemesanan::where('id_pemesanan', $id)->firstOrFail();

    $pemesanan->update([
        'id_penumpang'  => $request->id_penumpang,
        'id_jadwal'     => $request->id_jadwal,
        'tanggal_pesan' => $request->tanggal_pesan,
        'status'        => $request->status,
    ]);

    return redirect()
        ->route('pemesanan.pemesanantravel.index')
        ->with('success', 'Pemesanan berhasil diperbarui!');
}

    public function destroy($id)
    {
        $this->validateTravel();

        Pemesanan::findOrFail($id)->delete();

        return redirect()->route('pemesanan.pemesanantravel.index')
            ->with('success', 'Data berhasil dihapus!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Cancelled'
        ]);

        $user = Auth::user();
        if (!in_array($user->role, ['admin_travel', 'admin_pelayaran'])) {
            return back()->with('error', 'Akses ditolak!');
        }

        Pemesanan::findOrFail($id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    public function getPenumpangByName(Request $request)
    {
        $penumpang = Penumpang::where('nama_penumpang', 'LIKE', "%$request->nama%")->first();

        if (!$penumpang) {
            return response()->json(['error' => 'Penumpang tidak ditemukan']);
        }

        return response()->json($penumpang);
    }

    // validasi role
    private function validateTravel()
    {
        if (Auth::user()->role !== 'admin_travel') {
            abort(403, 'Akses ditolak (travel only)');
        }
    }

    private function viewPath()
    {
        return 'pemesanan.pemesanantravel';
    }

    public function show($id)
{
    $pemesanan = \App\Models\Pemesanan::with([
        'penumpang',
        'jadwal.kapal',
        'jadwal.jalur.pelabuhanAsal',
        'jadwal.jalur.pelabuhanTujuan'
    ])->findOrFail($id);

    return view('pemesanan.pemesanantravel.show', compact('pemesanan'));
}

}
