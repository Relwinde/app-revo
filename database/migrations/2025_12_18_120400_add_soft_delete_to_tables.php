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
        Schema::table('clients', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('fournisseurs', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('camions', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('dossiers', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('chauffeurs', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('fournisseurs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('camions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('dossiers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('chauffeurs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

    }
};
