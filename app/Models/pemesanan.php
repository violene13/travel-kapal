<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    public $timestamps = false;

    protected $fillable = [
        'id_penumpang',
        'id_jadwal',
        'id_admin_travel',
        'tanggal_pesan',
        'status',
    ];

    /**
     * Relasi ke tabel penumpang
     * Setiap pemesanan dimiliki oleh satu penumpang
     */
    public function penumpang()
    {
        return $this->belongsTo(Penumpang::class, 'id_penumpang', 'id_penumpang');
    }

    /**
     * Relasi ke tabel jadwal pelayaran
     * Setiap pemesanan punya satu jadwal pelayaran
     */
    public function jadwal()
    {
        return $this->belongsTo(JadwalPelayaran::class, 'id_jadwal', 'id_jadwal');
    }

    /**
     * Relasi ke admin travel
     * Setiap pemesanan dibuat oleh satu admin travel
     */
    public function travel()
    {
        return $this->belongsTo(User::class, 'id_admin_travel', 'id');
    }
}
