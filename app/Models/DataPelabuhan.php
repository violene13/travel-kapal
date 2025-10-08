<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPelabuhan extends Model
{
    protected $table = 'data_pelabuhan';
    protected $primaryKey = 'id_pelabuhan';
    public $timestamps = false;

    protected $fillable = [
        'nama_pelabuhan',
        'lokasi',
        'fasilitas_pelabuhan',
    ];

    public function jalurAsal()
    {
        return $this->hasMany(JalurPelayaran::class, 'id_pelabuhan_asal', 'id_pelabuhan');
    }

    public function jalurTujuan()
    {
        return $this->hasMany(JalurPelayaran::class, 'id_pelabuhan_tujuan', 'id_pelabuhan');
    }
}
