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
        Schema::create('personne_fonctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personne_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('valeur_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personne_fonctions');
    }
};
