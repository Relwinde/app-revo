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
        Schema::create('bon_de_caisses', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 14, 2);
            $table->string('depense');
            $table->enum('etape', ['EMETTEUR', 'RESPONSABLE', 'MANAGER', 'RAF', 'CAISSE', 'PAYE', 'CLOS'])->default('EMETTEUR');
            $table->boolean('rejected')->default(false);
            $table->foreignId('dossier_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('camion_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('numero', 2000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_de_caisses');
    }
};
