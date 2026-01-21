<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pemesanan;

class PembayaranController extends Controller
{
    public function show($id_pemesanan)
    {
        $pemesanan = Pemesanan::where('id_pemesanan', $id_pemesanan)
            ->firstOrFail();

        // kalau sudah confirmed, langsung ke e-ticket
        if ($pemesanan->status === 'Confirmed') {
            return redirect()->route('pemesanan.eticket', $id_pemesanan);
        }

        $penumpang = DB::table('pemesanan_penumpang')
            ->where('id_pemesanan', $id_pemesanan)
            ->get();

        $total = $penumpang->sum('harga');

        $metodePembayaran = DB::table('metode_pembayaran')->get();

        return view('pemesanan.pemesananpengguna.pembayaran', compact(
            'pemesanan',
            'penumpang',
            'total',
            'metodePembayaran'
        ));
    }

    public function proses(Request $request, $id_pemesanan)
    {
        $request->validate([
            'id_metode' => 'required|exists:metode_pembayaran,id_metode'
        ]);

        // 🔴 HARUS Pending (kapital)
        $pemesanan = Pemesanan::where('id_pemesanan', $id_pemesanan)
            ->where('status', 'Pending')
            ->firstOrFail();

        DB::transaction(function () use ($pemesanan, $request) {

            $total = DB::table('pemesanan_penumpang')
                ->where('id_pemesanan', $pemesanan->id_pemesanan)
                ->sum('harga');

            DB::table('pembayaran')->insert([
                'id_pemesanan'      => $pemesanan->id_pemesanan,
                'id_metode'         => $request->id_metode,
                'tanggal_bayar'     => now(),
                'jumlah_bayar'      => $total,
                'status_pembayaran' => 'Confirmed'
            ]);

            $pemesanan->update([
                'status' => 'Confirmed'
            ]);
        });

        return redirect()
            ->route('pemesanan.eticket', $pemesanan->id_pemesanan)
            ->with('success', 'Pembayaran berhasil, e-ticket siap dicetak');
    }
}
