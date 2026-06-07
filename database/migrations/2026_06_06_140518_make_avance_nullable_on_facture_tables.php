<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE facture_proformas MODIFY avance DECIMAL(15, 2) NULL');
        DB::statement('ALTER TABLE factures MODIFY avance DECIMAL(15, 2) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE facture_proformas MODIFY avance DECIMAL(15, 2) NOT NULL');
        DB::statement('ALTER TABLE factures MODIFY avance DECIMAL(15, 2) NOT NULL');
    }
};
