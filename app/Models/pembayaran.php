<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false;

    protected $fillable = [
        'id_pemesanan',
        'id_metode',
        'tanggal_bayar',
        'jumlah_bayar',
        'status_bayar'
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    public function metode()
    {
        return $this->belongsTo(MetodePembayaran::class, 'id_metode');
    }
}
