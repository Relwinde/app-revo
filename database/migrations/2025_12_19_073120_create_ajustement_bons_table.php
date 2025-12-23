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
        Schema::create('ajustement_bons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bon_de_caisse_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('libelle');
            $table->enum('type', ['EXCEDANT', 'RESTITUTION']);
            $table->decimal('montant_bon_before', 14, 2);
            $table->decimal('montant', 14, 2);
            $table->decimal('montant_bon_after', 14, 2);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajustement_bons');
    }
};
