<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    public $timestamps = true;

    protected $fillable = [
        'nama_penumpang',
        'jadwal',
        'rute',
        'no_hp',
        'kapal',
        'kelas',
        'status', 
        'tipe',   
    ];
}
