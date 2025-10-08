<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminTravel extends Authenticatable
{
    protected $table = 'admin_travel';

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];
}
