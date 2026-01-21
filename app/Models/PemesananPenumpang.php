<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananPenumpang extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_penumpang';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_pemesanan',
        'id_penumpang',
         'nama_lengkap',
        'jenis_tiket',   
        'kelas',         
        'harga',
    ];

    /**
     * RELASI KE PEMESANAN (HEADER)
     */
    public function pemesanan()
    {
        return $this->belongsTo(
            Pemesanan::class,
            'id_pemesanan',
            'id_pemesanan'
        );
    }
}
