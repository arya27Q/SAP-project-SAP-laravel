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
        Schema::connection('pt4')->create('customers', function (Blueprint $table) {
         $table->string('CardCode', 15)->primary(); 

            // Core identity
            $table->string('CardName', 100)->nullable(); 
            $table->char('CardType', 1)->nullable();     // 'C' Customer, 'S' Supplier, 'L' Lead
            $table->integer('GroupCode')->nullable();   

            // Tax / legal
            $table->string('LicTradNum', 32)->nullable(); // NPWP / Tax ID (panjang bisa beda, ini aman)
            $table->char('VatLiable', 1)->nullable();     

            // Contact
            $table->string('Phone1', 20)->nullable();
            $table->string('Phone2', 20)->nullable();
            $table->string('Cellular', 20)->nullable();
            $table->string('Fax', 20)->nullable();
            $table->string('E_Mail', 100)->nullable();
            $table->string('CntctPrsn', 90)->nullable();  // Contact Person

            // Address (basic)
            $table->string('Address', 100)->nullable();   // Default address label
            $table->string('Street', 100)->nullable();
            $table->string('Block', 100)->nullable();
            $table->string('ZipCode', 20)->nullable();
            $table->string('City', 100)->nullable();
            $table->string('County', 100)->nullable();
            $table->string('Country', 3)->nullable();     // ISO-ish (SAP kadang pakai kode internal)

            // Financial (pakai decimal, jangan float)
            $table->string('Currency', 3)->nullable();    // 'IDR', 'USD', dll
            $table->decimal('Balance', 18, 2)->nullable();
            $table->decimal('OrdersBal', 18, 2)->nullable();
            $table->decimal('DNotesBal', 18, 2)->nullable();

            // Status flags
            $table->char('ValidFor', 1)->nullable();      // 'Y'/'N'
            $table->char('FrozenFor', 1)->nullable();     // 'Y'/'N'
            $table->date('FrozenFrom')->nullable();
            $table->date('FrozenTo')->nullable();

            // Notes
            $table->text('Notes')->nullable();

            // SAP dates (kalau kamu sync dari SAP, ini berguna buat incremental load)
            $table->date('CreateDate')->nullable();
            $table->date('UpdateDate')->nullable();

            // Optional: tempat naruh field tambahan/UDF tanpa nambah kolom terus-terusan
            $table->json('UdfJson')->nullable();

            // Laravel timestamps (untuk tracking kapan data masuk ke DB kamu)
            $table->timestamps();

            // Indexes (buat search & join cepet)
            $table->index('CardName');
            $table->index('GroupCode');
            $table->index('LicTradNum');
            $table->index('E_Mail');
            $table->index(['CardType', 'ValidFor', 'FrozenFor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pt4')->dropIfExists('customers');
    }
};
