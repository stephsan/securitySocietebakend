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
        Schema::create('valeurs', function (Blueprint $table) {
            $table->id();
            $table->string("libelle");
            $table->foreignId('valeur_id')
                ->nullable()
                ->constrained('valeurs') // auto-référence à la table valeurs
                ->nullOnDelete(); // met NULL si la valeur parent est supprimée
  
            $table->foreignId('parametre_id')
                    ->constrained()
                    ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valeurs');
    }
};
