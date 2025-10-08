<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    public $timestamps = false;

    protected $fillable = [
        'id_penumpang',
        'id_jadwal',
        'id_admin_travel',
        'tanggal_pesan',
        'status'
    ];

    // Relasi ke Penumpang
    public function penumpang()
    {
        return $this->belongsTo(Penumpang::class, 'id_penumpang', 'id_penumpang');
    }

    // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->belongsTo(JadwalPelayaran::class, 'id_jadwal', 'id_jadwal');
    }

    // Relasi ke Pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pemesanan', 'id_pemesanan');
    }
}
