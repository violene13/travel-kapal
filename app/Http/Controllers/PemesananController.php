<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Penumpang;
use App\Models\JadwalPelayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    /**
     * Form tambah pemesanan baru
     */
    public function create()
    {
        $jadwals = JadwalPelayaran::with(['kapal', 'jalur.pelabuhanAsal', 'jalur.pelabuhanTujuan'])
            ->where('tanggal_berangkat', '>', now())
            ->orderBy('tanggal_berangkat')
            ->get();
        
        return view('pemesanan.create', compact('jadwals'));
    }

    /**
     * Simpan pemesanan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_pelayaran,id_jadwal',
            'penumpang' => 'required|array|min:1',
            'penumpang.*.nama_penumpang' => 'required|string|max:255',
            'penumpang.*.no_hp' => 'required|string|max:15',
            'penumpang.*.alamat' => 'required|string',
            'penumpang.*.jenis_identitas' => 'required|in:KTP,SIM,Passport',
            'penumpang.*.no_identitas' => 'required|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->penumpang as $dataPenumpang) {
                $penumpang = Penumpang::create($dataPenumpang);

                Pemesanan::create([
                    'id_jadwal' => $request->jadwal_id,
                    'id_penumpang' => $penumpang->id_penumpang,
                    'tanggal_pesan' => now(), // pastikan field di DB = tanggal_pesan
                    'status' => 'pending',   // pastikan field di DB = status
                ]);
            }

            DB::commit();
            return redirect()->route('pemesanan.index')
                ->with('success', 'Pemesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan pemesanan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Daftar semua pemesanan
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Pemesanan::with([
            'penumpang',
            'jadwal.kapal',
            'jadwal.jalur.pelabuhanAsal',
            'jadwal.jalur.pelabuhanTujuan',
            'pembayaran'
        ]);

        if ($search) {
            $query->whereHas('penumpang', function ($q) use ($search) {
                $q->where('nama_penumpang', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            })
            ->orWhereHas('jadwal.kapal', function ($q) use ($search) {
                $q->where('nama_kapal', 'like', "%{$search}%");
            })
            ->orWhereHas('jadwal.jalur.pelabuhanAsal', function ($q) use ($search) {
                $q->where('lokasi', 'like', "%{$search}%");
            })
            ->orWhereHas('jadwal.jalur.pelabuhanTujuan', function ($q) use ($search) {
                $q->where('lokasi', 'like', "%{$search}%");
            });
        }

        $pemesanan = $query->paginate(15);

        return view('pemesanan.index', compact('pemesanan'));
    }

    /**
     * Detail pemesanan
     */
    public function show($id)
    {
        $pemesanan = Pemesanan::with([
            'penumpang',
            'jadwal.kapal',
            'jadwal.jalur.pelabuhanAsal',
            'jadwal.jalur.pelabuhanTujuan',
            'pembayaran'
        ])->findOrFail($id);

        return view('pemesanan.show', compact('pemesanan'));
    }

    /**
     * Form edit pemesanan
     */
    public function edit($id)
    {
        $pemesanan = Pemesanan::with(['penumpang', 'jadwal'])->findOrFail($id);
        $jadwals = JadwalPelayaran::with(['kapal', 'jalur.pelabuhanAsal', 'jalur.pelabuhanTujuan'])->get();

        // daftar status pemesanan
        $statusList = ['pending', 'confirmed', 'cancelled'];

        return view('pemesanan.edit', compact('pemesanan', 'jadwals', 'statusList'));
    }

    /**
     * Update pemesanan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_pelayaran,id_jadwal',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->update([
            'id_jadwal' => $request->jadwal_id,
            'status' => $request->status,
        ]);

        return redirect()->route('pemesanan.index')
            ->with('success', 'Pemesanan berhasil diperbarui!');
    }

    /**
     * Hapus pemesanan
     */
    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->delete();

        return redirect()->route('pemesanan.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}
