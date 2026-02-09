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
        Schema::create('facture_proformas', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->date('date');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('chauffeur_id')->nullable()->constrained('chauffeurs')->onDelete('cascade');
            $table->foreignId('camion_id')->nullable()->constrained('camions')->onDelete('cascade');
            $table->string('personne_contact')->nullable();
            $table->integer('payment_terms')->default(30)->nullable();
            $table->string('payment_conditions')->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_proformas');
    }
};
