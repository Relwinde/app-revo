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
        // Migrate existing dossier_id relationships to the pivot table
        $commandes = DB::table('commandes')->whereNotNull('dossier_id')->get();

        foreach ($commandes as $commande) {
            DB::table('commande_dossier')->insert([
                'commande_id' => $commande->id,
                'dossier_id' => $commande->dossier_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('commande_dossier')->truncate();
    }
};
