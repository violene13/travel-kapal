<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penumpang extends Model
{
    use HasFactory;

    protected $table = 'penumpang';
    protected $primaryKey = 'id_penumpang';

    protected $fillable = [
        'id_user',
        'nama_penumpang',
        'email',
        'foto',
        'no_hp',
        'alamat',
        'no_ktp',
        'gender',
        'tanggal_lahir',
    ];

    /* ================= RELATION ================= */

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'id_penumpang', 'id_penumpang');
    }
}
