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
            $table->enum('type_paiement', ['ESPECE', 'CHEQUE'])->after('etape')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bon_de_caisses', function (Blueprint $table) {
            $table->dropColumn('type_paiement');
        });
    }
};
