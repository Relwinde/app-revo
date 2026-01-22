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
        Schema::table('dossiers', function (Blueprint $table) {
            $table->string("service")->nullable()->before("type_operation");
            $table->string("escort")->nullable()->before("type_operation"); 
            $table->string("compagnon")->nullable()->before("type_operation");
            $table->string("lieu")->nullable()->before("type_operation"); 
            $table->string("motif")->nullable()->before("type_operation");
            $table->date("date_depart")->nullable()->before("type_operation");
            $table->date("date_retour")->nullable()->before("type_operation");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dossiers', function (Blueprint $table) {
            $table->dropColumn("service");
            $table->dropColumn("escort");
            $table->dropColumn("compagnon"); 
            $table->dropColumn("lieu");
            $table->dropColumn("motif"); 
            $table->dropColumn("date_depart"); 
            $table->dropColumn("date_retour");
        });
    }
};
