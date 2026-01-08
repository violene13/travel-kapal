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

    
    public function penumpang()
    {
        return $this->belongsTo(Penumpang::class, 'id_penumpang', 'id_penumpang');
    }

   
    public function jadwal()
    {
        return $this->belongsTo(JadwalPelayaran::class, 'id_jadwal', 'id_jadwal');
    }

   
    public function travel()
    {
        return $this->belongsTo(User::class, 'id_admin_travel', 'id');
    }
}
