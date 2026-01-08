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
        'id_kapal' => 'required|exists:data_kapal,id_kapal',
        'id_jalur' => 'required|exists:jalur_pelayaran,id_jalur',
        'kelas'    => 'required|string|max:50',
        'harga'    => 'required|array'
    ]);

    foreach ($request->harga as $jenis => $harga) {

        // skip jika harga kosong
        if ($harga === null || $harga === '') {
            continue;
        }

        Ticketing::updateOrCreate(
            [
                'id_kapal'    => $request->id_kapal,
                'id_jalur'    => $request->id_jalur,
                'kelas'       => $request->kelas,
                'jenis_tiket' => $jenis,
            ],
            [
                'harga' => $harga
            ]
        );
    }

    return redirect()->route('ticketing.index')
        ->with('success', 'Harga tiket berhasil disimpan.');
}


public function edit($groupKey)
{
    [$id_kapal, $id_jalur, $kelas] = explode('|', $groupKey);

    $ticketings = Ticketing::where([
        'id_kapal' => $id_kapal,
        'id_jalur' => $id_jalur,
        'kelas'    => $kelas,
    ])->get()
      ->mapWithKeys(fn($t) => [
          trim(ucfirst(strtolower($t->jenis_tiket))) => $t
      ]);

    $kapals = DataKapal::all();
    $jalurs = JalurPelayaran::with(['pelabuhanAsal','pelabuhanTujuan'])->get();

    return view('ticketing.edit', compact(
        'ticketings',
        'kapals',
        'jalurs',
        'id_kapal',
        'id_jalur',
        'kelas',
        'groupKey'
    ));
}


  public function update(Request $request)
{
    foreach ($request->harga as $jenis => $harga) {

        if ($harga === null || $harga === '' || $harga <= 0) {
            Ticketing::where([
                'id_kapal'    => $request->id_kapal,
                'id_jalur'    => $request->id_jalur,
                'kelas'       => $request->kelas,
                'jenis_tiket' => $jenis,
            ])->delete();
            continue;
        }

        Ticketing::updateOrCreate(
            [
                'id_kapal'    => $request->id_kapal,
                'id_jalur'    => $request->id_jalur,
                'kelas'       => $request->kelas,
                'jenis_tiket' => $jenis,
            ],
            ['harga' => $harga]
        );
    }

    return redirect()
        ->route('ticketing.index')
        ->with('success', 'Harga tiket berhasil diperbarui');
}


    public function destroy(Ticketing $ticketing)
    {
        $ticketing->delete();

        return redirect()->route('ticketing.index')
            ->with('success', 'Harga tiket berhasil dihapus.');
    }
}
