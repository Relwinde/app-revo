<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('capital')->nullable();
            $table->text('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('rccm')->nullable();
            $table->string('ifu')->nullable();
            $table->string('regime_imposition')->nullable();
            $table->string('division_fiscale')->nullable();
            $table->timestamps();
        });

        DB::table('entreprises')->insert([
            'capital' => '100 000 FCFA',
            'adresse' => "979 Boulevard Charles de Gaulle, Arr.10\n11 BP 3105 Ouagadougou 01",
            'telephone' => '(+226) 25 48 11 12',
            'email' => 'info@revo-limited.com',
            'rccm' => 'BF OUA2021 B11588',
            'ifu' => '00167673T',
            'regime_imposition' => "Régime Simplifié d'Imposition (RSI)",
            'division_fiscale' => 'Ouaga V',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
