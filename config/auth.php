<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Default guard tetap 'web' (buat Admin Desktop).
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards (PINTU MASUK)
    |--------------------------------------------------------------------------
    |
    | Di sini kita tambahkan pintu khusus buat Tablet (QC).
    |
    */

    'guards' => [
        // 1. Pintu Admin (Desktop) - Pakai Session/Cookies
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // 2. Pintu QC (Tablet) - Pakai Token Sanctum
        'tablet' => [
            'driver' => 'sanctum',
            'provider' => 'tablet_users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers (SUMBER DATA)
    |--------------------------------------------------------------------------
    |
    | Di sini kita kasih tau Laravel tabel mana yang dipakai.
    |
    */

    'providers' => [
        // 1. Data Admin - Tabel 'users' (Model User)
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        // 2. 👇 INI BARU: Data QC - Tabel 'tablet_users' (Model TabletUser)
        'tablet_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\TabletUser::class, // Pastikan Model ini sudah dibuat
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
        
        // (Opsional) Kalau QC mau bisa reset password juga, tambahin ini:
        'tablet_users' => [
            'provider' => 'tablet_users',
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
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];