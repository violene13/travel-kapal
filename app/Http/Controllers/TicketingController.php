<?php

namespace App\Http\Controllers;

use App\Models\Ticketing;
use App\Models\DataKapal;
use App\Models\JalurPelayaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketingController extends Controller
{
    public function index()
    {
        $ticketing = Ticketing::with([
            'kapal',
            'jalur.pelabuhanAsal',
            'jalur.pelabuhanTujuan'
        ])->get();

        return view('ticketing.index', compact('ticketing'));
    }

    public function create()
    {
        $kapals = DataKapal::all();
        $jalurs = JalurPelayaran::with(['pelabuhanAsal', 'pelabuhanTujuan'])->get();

        return view('ticketing.create', compact('kapals', 'jalurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kapal'    => 'required|exists:data_kapal,id_kapal',
            'id_jalur'    => 'required|exists:jalur_pelayaran,id_jalur',
            'kelas'       => 'required|string|max:50',
            'jenis_tiket' => 'required|in:Dewasa,Anak,Bayi',
            'harga'       => 'required|numeric|min:0',

            // ❗ Cegah duplikasi
            Rule::unique('ticketings')->where(function ($q) use ($request) {
                return $q->where('id_kapal', $request->id_kapal)
                         ->where('id_jalur', $request->id_jalur)
                         ->where('kelas', $request->kelas)
                         ->where('jenis_tiket', $request->jenis_tiket);
            }),
        ]);

        Ticketing::create([
            'id_kapal'    => $request->id_kapal,
            'id_jalur'    => $request->id_jalur,
            'kelas'       => $request->kelas,
            'jenis_tiket' => $request->jenis_tiket,
            'harga'       => $request->harga,
        ]);

        return redirect()->route('ticketing.index')
            ->with('success', 'Harga tiket berhasil ditambahkan.');
    }

    public function edit(Ticketing $ticketing)
    {
        $kapals = DataKapal::all();
        $jalurs = JalurPelayaran::with(['pelabuhanAsal', 'pelabuhanTujuan'])->get();

        return view('ticketing.edit', compact('ticketing', 'kapals', 'jalurs'));
    }

    public function update(Request $request, Ticketing $ticketing)
    {
        $request->validate([
            'id_kapal'    => 'required|exists:data_kapal,id_kapal',
            'id_jalur'    => 'required|exists:jalur_pelayaran,id_jalur',
            'kelas'       => 'required|string|max:50',
            'jenis_tiket' => 'required|in:Dewasa,Anak,Bayi',
            'harga'       => 'required|numeric|min:0',
        ]);

        $ticketing->update([
            'id_kapal'    => $request->id_kapal,
            'id_jalur'    => $request->id_jalur,
            'kelas'       => $request->kelas,
            'jenis_tiket' => $request->jenis_tiket,
            'harga'       => $request->harga,
        ]);

        return redirect()->route('ticketing.index')
            ->with('success', 'Harga tiket berhasil diperbarui.');
    }

    public function destroy(Ticketing $ticketing)
    {
        $ticketing->delete();

        return redirect()->route('ticketing.index')
            ->with('success', 'Harga tiket berhasil dihapus.');
    }
}
