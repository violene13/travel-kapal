<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Penumpang extends Authenticatable
{
    use HasFactory;

    protected $table = 'penumpang';
    protected $primaryKey = 'id_penumpang';
    public $timestamps = false;

    protected $fillable = [
        'nama_penumpang',
        'email',
        'foto',
        'password',
        'no_hp',
        'alamat',
        'no_ktp',
        'gender',
        'tanggal_lahir',
    ];

    protected $hidden = [
        'password',
    ];

    // ⛔ Matikan fitur remember_token karena tabel tidak punya kolom ini
    public function getRememberToken() { return null; }
    public function setRememberToken($value) { }
    public function getRememberTokenName() { return null; }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'id_penumpang', 'id_penumpang');
    }
}
