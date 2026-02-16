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
        Schema::table('facture_proformas', function (Blueprint $table) {
            $table->text("comments")->nullable();
            $table->decimal('avance', 15, 2);
        });

        Schema::table('factures', function (Blueprint $table) {
            $table->text("comments")->nullable();
            $table->decimal('avance', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facture_proformas', function (Blueprint $table) {
            $table->dropColumn('comments');
            $table->dropColumn('avance');
        });

         Schema::table('factures', function (Blueprint $table) {
            $table->dropColumn('comments');
            $table->dropColumn('avance');
        });
    }
};
