<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // PENTING: Ganti ini
use Laravel\Sanctum\HasApiTokens; // PENTING: Buat Token Flutter

class TabletUser extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $connection = 'pt4'; // Konek ke master_bp
    protected $table = 'tablet_users'; // Sesuai skema kamu

    protected $fillable = [
        'email',
        'nama_lengkap',
        'password',
        'role', // default: 'qc_staff'
        'must_set_password',
        'is_active',
    ];

    protected $hidden = [
        'password', // Sembunyikan password saat return JSON
    ];

    protected $casts = [
        'must_set_password' => 'boolean',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
    ];
}