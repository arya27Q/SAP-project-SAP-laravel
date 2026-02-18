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
        Schema::connection('pt4')->create('tablet_users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password')->nullable();  //nullable karena diawal2
            $table->string('nama_lengkap');
            $table->string('role')->default('qc_staff');
            $table->boolean('must_set_password')->default(true); //buat ganti paksa pw
            $table->boolean('is_active')->default(true); // Buat mematikan akses jika resign
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pt4')->dropIfExists('tablet_users');
    }
};
