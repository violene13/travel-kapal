<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKapal extends Model
{
    protected $table = 'data_kapal';
    protected $primaryKey = 'id_kapal';
    public $timestamps = false;

    protected $fillable = [
        'nama_kapal',
        'jenis_kapal',
        'kapasitas'
    ];

    // Relasi ke Jadwal Pelayaran
    public function jadwal()
    {
        return $this->hasMany(JadwalPelayaran::class, 'id_kapal');
    }
}
