<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Menentukan guard & password broker default yang digunakan aplikasi.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Guard mengatur bagaimana pengguna diautentikasi untuk setiap permintaan.
    | Kita gunakan dua guard:
    | - web: untuk admin_travel & admin_pelayaran
    | - penumpang: untuk user biasa (pelanggan)
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'penumpang' => [
            'driver' => 'session',
            'provider' => 'penumpang',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Provider mendefinisikan bagaimana pengguna diambil dari database.
    | Kita pakai model User & Penumpang (masing-masing tabel berbeda).
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'penumpang' => [
            'driver' => 'eloquent',
            'model' => App\Models\Penumpang::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Menentukan tabel token reset password dan waktu kedaluwarsa.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'penumpang' => [
            'provider' => 'penumpang',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Waktu (dalam detik) sebelum pengguna harus konfirmasi ulang password.
    | Default: 3 jam.
    |
    */

    'password_timeout' => 10800,

];
