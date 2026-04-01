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
        Schema::table('personnes', function (Blueprint $table) {
            $table->string('lieu_de_naissance',120)->nullable(); 
            $table->integer('situation_matrimoniale')->nullable();
            $table->string('nom_du_conjoint')->nullable();
            $table->string('contacts',60)->nullable();
            $table->string('personne_a_prevenir')->nullable();
            $table->date('date_depart',)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personnes', function (Blueprint $table) {
            $table->dropColumn('lieu_de_naissance');
            $table->dropColumn('situation_matrimoniale');
            $table->dropColumn('nom_du_conjoint');
            $table->dropColumn('contacts');
            $table->dropColumn('personne_a_prevenir');
            $table->dropColumn('date_depart');
        });
    }
};
