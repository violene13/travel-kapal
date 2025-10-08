<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    protected $table = 'metode_pembayaran';
    protected $primaryKey = 'id_metode';
    public $timestamps = false;

    protected $fillable = ['nama_metode', 'keterangan'];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_metode');
    }
}
