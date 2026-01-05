<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'harga',
        'kelas',
    ];

    /** ======================= RELASI ======================= **/

    // Relasi ke Jalur Pelayaran
    public function jalur()
    {
        return $this->belongsTo(JalurPelayaran::class, 'id_jalur', 'id_jalur');
    }

    // Relasi ke Kapal
    public function kapal()
    {
        return $this->belongsTo(DataKapal::class, 'id_kapal', 'id_kapal');
    }

    // Relasi dasar ke Ticketing (hanya berdasarkan jalur)
    public function ticketings()
    {
        return $this->hasMany(Ticketing::class, 'id_jalur', 'id_jalur');
    }

    // Ticketing yang sesuai kapal untuk jadwal ini
    public function ticketingsByKapal()
    {
        return $this->hasMany(Ticketing::class, 'id_jalur', 'id_jalur')
                    ->where('id_kapal', $this->id_kapal);
    }

    /** ======================= ACCESSOR ======================= **/

    // Aksesor Rute: Asal - Tujuan
    public function getTujuanAttribute()
    {
        $asal   = $this->jalur?->pelabuhanAsal?->lokasi ?? '-';
        $tujuan = $this->jalur?->pelabuhanTujuan?->lokasi ?? '-';

        return "{$asal} - {$tujuan}";
    }

    /** ======================= HELPER ======================= **/

    // Ambil harga berdasarkan kelas dari ticketing yang sesuai kapal
    public function getHargaByKelas($kelas)
    {
        $ticket = $this->ticketingsByKapal()
                       ->where('kelas', $kelas)
                       ->first();

        return $ticket ? $ticket->harga : null;
    }

    // Ambil daftar kelas tersedia untuk kapal pada jalur ini
    public function getAvailableKelas()
    {
        return $this->ticketingsByKapal()
                    ->select('kelas')
                    ->distinct()
                    ->pluck('kelas');
    }
}
