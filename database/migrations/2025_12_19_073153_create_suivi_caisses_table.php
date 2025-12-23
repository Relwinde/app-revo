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
        Schema::create('suivi_caisses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bon_de_caisse_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('depot_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('ajustement_bon_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('solde_before', 14, 2);
            $table->decimal('montant', 14, 2);
            $table->decimal('solde_after', 14, 2);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suivi_caisses');
    }
};
