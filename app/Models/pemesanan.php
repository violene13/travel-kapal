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
        'sumber_pemesanan',
        'id_penumpang',      // pemesan utama
        'id_jadwal',
        'id_admin_travel',
        'tanggal_pesan',
        'total_harga',
        'status',
    ];

    /**
     * JADWAL PELAYARAN
     */
    public function jadwal()
    {
        return $this->belongsTo(
            JadwalPelayaran::class,
            'id_jadwal',
            'id_jadwal'
        );
    }

    /**
     * ADMIN TRAVEL (jika sumber = admin_travel)
     */
    public function adminTravel()
    {
        return $this->belongsTo(
            AdminTravel::class,
            'id_admin_travel',
            'id_admin_travel'
        );
    }
    /**
     * PENUMPANG PEMESAN (1 orang)
     */
public function penumpang()
{
    return $this->belongsTo(
        Penumpang::class,
        'id_penumpang',
        'id_penumpang'
    );
}

    /**
     * DETAIL PENUMPANG (BANYAK)
     */
    public function detailPenumpang()
    {
        return $this->hasMany(
            PemesananPenumpang::class,
            'id_pemesanan',
            'id_pemesanan'
        );
    }
}
