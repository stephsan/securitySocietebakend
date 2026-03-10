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
            $table->string('numero_rccm')->nullable();
            $table->string('numero_ifu')->nullable();
            $table->integer('regime_fiscal')->nullable();
            $table->integer('division_fiscale')->nullable();
            $table->string('adresse_siege')->nullable();
            $table->string('section')->nullable();
            $table->string('boite_postale',100)->nullable();
            $table->string('telephone_mobile',100)->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('numero_rccm');
            $table->dropColumn('numero_ifu');
            $table->dropColumn('regime_fiscal');
            $table->dropColumn('adresse_siege');
            $table->dropColumn('section');
            $table->dropColumn('boite_postale');
            $table->dropColumn('telephone_mobile');
            $table->dropColumn('division_fiscale');

        });
    }
};
