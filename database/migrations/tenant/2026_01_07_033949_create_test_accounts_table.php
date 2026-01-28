<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // --- TAMBAHAN: Cek dulu apakah tabel 'akun' sudah ada ---
        // Kalau tabel belum ada, baru dibuat. Kalau sudah ada, dilewati.
        if (!Schema::hasTable('akun')) {
            
            Schema::create('akun', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique(); 
                $table->string('password');
                // pt_name dihapus karena akun sudah berada di dalam database tenant masing-masing
                $table->timestamps();
            });
            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};