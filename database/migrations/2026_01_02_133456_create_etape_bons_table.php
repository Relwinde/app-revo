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
        Schema::create('etape_bons', function (Blueprint $table) {
            $table->id();
            $table->enum('etape_precedente', ['EMETTEUR', 'MANAGER', 'CAISSE', 'PAYE', 'CLOS'])->default('EMETTEUR');
            $table->enum('etape_actuelle', ['EMETTEUR', 'MANAGER', 'CAISSE', 'PAYE', 'CLOS'])->default('EMETTEUR');
            $table->decimal('montant', 14, 2);
            $table->foreignId('bon_de_caisse_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etape_bons');
    }
};
