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
        Schema::create('facture_items', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['DEF', 'PRO']);
            $table->foreignId('facture_proforma_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('facture_id')->nullable()->constrained()->onDelete('set null');
            $table->string('description');
            $table->integer('quantity');
            $table->string('unit');
            $table->decimal('unit_price', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_items');
    }
};
