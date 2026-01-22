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
        Schema::table('commandes', function (Blueprint $table) {
            if (Schema::hasColumn('commandes', 'fournisseur_id')) {
                $table->dropForeign(['fournisseur_id']);
                $table->dropColumn('fournisseur_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->foreignId('fournisseur_id')->nullable()->references('id')->on('fournisseurs')->onDelete('cascade');
        });
    }
};
