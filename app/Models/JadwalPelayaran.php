<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelayaran extends Model
{
    protected $table = 'jadwal_pelayaran';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;

    protected $fillable = [
        'id_kapal',
        'id_jalur',
        'id_pelabuhan_asal',
        'id_pelabuhan_tujuan',
        'tanggal_berangkat',
        'jam_berangkat',
        'jam_tiba',
        'harga_tiket',
        'kelas_tiket',
    ];

    // Relasi ke DataKapal
    public function kapal()
    {
        return $this->belongsTo(DataKapal::class, 'id_kapal', 'id_kapal');
    }

    // Relasi ke Jalur Pelayaran
    public function jalur()
    {
        return $this->belongsTo(JalurPelayaran::class, 'id_jalur', 'id_jalur');
    }

    // Relasi ke Pelabuhan Asal
    public function pelabuhanAsal()
    {
        return $this->belongsTo(DataPelabuhan::class, 'id_pelabuhan_asal', 'id_pelabuhan');
    }

    // Relasi ke Pelabuhan Tujuan
    public function pelabuhanTujuan()
    {
        return $this->belongsTo(DataPelabuhan::class, 'id_pelabuhan_tujuan', 'id_pelabuhan');
    }
}
