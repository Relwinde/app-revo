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
        Schema::table('bon_de_caisses', function (Blueprint $table) {
            $table->string('numero_cheque')->nullable()->after('type_paiement');
            $table->string('banque_cheque')->nullable()->after('numero_cheque');
            $table->date('date_cheque')->nullable()->after('banque_cheque');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bon_de_caisses', function (Blueprint $table) {
            $table->dropColumn(['numero_cheque', 'banque_cheque', 'date_cheque']);
        });
    }
};
