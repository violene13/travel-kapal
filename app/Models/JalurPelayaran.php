<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JalurPelayaran extends Model
{
    protected $table = 'jalur_pelayaran';
    protected $primaryKey = 'id_jalur';
    public $timestamps = false;

    protected $fillable = [
        'id_pelabuhan_asal',
        'id_pelabuhan_tujuan',
        'durasi',
        'jarak',
    ];

    /** Relasi ke pelabuhan asal */
    public function pelabuhanAsal()
    {
        return $this->belongsTo(DataPelabuhan::class, 'id_pelabuhan_asal', 'id_pelabuhan');
    }

    /** Relasi ke pelabuhan tujuan */
    public function pelabuhanTujuan()
    {
        return $this->belongsTo(DataPelabuhan::class, 'id_pelabuhan_tujuan', 'id_pelabuhan');
    }

    /** Relasi ke jadwal pelayaran */
    public function jadwal()
    {
        return $this->hasMany(JadwalPelayaran::class, 'id_jalur', 'id_jalur');
    }

    /** Relasi ke ticketing */
    public function ticketings()
    {
        return $this->hasMany(Ticketing::class, 'id_jalur', 'id_jalur');
    }

    /** Accessor untuk menampilkan rute (Asal → Tujuan) */
    public function getRuteAttribute()
    {
        $asal = $this->pelabuhanAsal?->lokasi ?? '-';
        $tujuan = $this->pelabuhanTujuan?->lokasi ?? '-';
        return "{$asal} → {$tujuan}";
    }
}
