<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Laravel\Sanctum\HasApiTokens; 

class TabletUser extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $connection = 'pt4'; 
    protected $table = 'tablet_users'; 

    protected $fillable = [
        'email',
        'nama_lengkap',
        'password',
        'role', 
        'must_set_password',
        'is_active',
    ];

    protected $hidden = [
        'password', 
    ];

    protected $casts = [
        'must_set_password' => 'boolean',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
    ];
}