<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JalurPelayaran;
use App\Models\DataKapal;
use App\Models\Ticketing;

class JadwalPelayaran extends Model
{
    protected $table = 'jadwal_pelayaran';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;

    protected $fillable = [
        'id_jalur',
        'id_kapal',
        'tanggal_berangkat',
        'jam_berangkat',
        'jam_tiba',
        'kelas',
    ];

    public function jalur()
    {
        return $this->belongsTo(JalurPelayaran::class, 'id_jalur', 'id_jalur');
    }

    public function kapal()
    {
        return $this->belongsTo(DataKapal::class, 'id_kapal', 'id_kapal');
    }

    /**
     * Ticketing YANG BENAR-BENAR SESUAI JADWAL
     * - jalur sama
     * - kapal sama
     * - kelas sama
     * - hanya yang ADA di database
     */
    public function ticketings()
    {
        return Ticketing::where('id_jalur', $this->id_jalur)
            ->where('id_kapal', $this->id_kapal)
            ->where('kelas', $this->kelas);
    }
}
