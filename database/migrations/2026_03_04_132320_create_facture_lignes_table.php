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
        Schema::create('facture_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facture_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contrat_ligne_id')->constrained()->cascadeOnDelete();
            $table->foreignId('prestation_id')->constrained()->cascadeOnDelete();
            $table->integer('quantite');
            $table->bigInteger('montant');
            $table->bigInteger('montant_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_lignes');
    }
};
