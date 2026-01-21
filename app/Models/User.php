<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Penumpang;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* ================= RELATIONS ================= */

    public function penumpang()
    {
        return $this->hasOne(Penumpang::class, 'id_user', 'id');
    }

    /* ================= ROLE HELPERS ================= */

    public function isAdminTravel()
    {
        return $this->role === 'admin_travel';
    }

    public function isAdminPelayaran()
    {
        return $this->role === 'admin_pelayaran';
    }

    public function isPenumpang()
    {
        return $this->role === 'penumpang';
    }
}
