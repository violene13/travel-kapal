<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Penumpang extends Authenticatable
{
    protected $table = 'penumpang';   
    protected $primaryKey = 'id_penumpang';
    public $timestamps = false;      

    protected $fillable = [
        'username',
        'nama_penumpang',
        'email',
        'password',
        'no_handphone',
        'alamat',
        'no_ktp',
        'gender',
        'tanggal_lahir',
    ];

    protected $hidden = [
        'password',
    ];
}
