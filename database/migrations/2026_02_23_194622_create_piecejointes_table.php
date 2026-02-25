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
        Schema::create('piecejointes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personne_id')->constrained()->cascadeOnDelete();
            $table->integer("client_id")->nullable();
            $table->string("type_document");
            $table->string('nom_original')->nullable();
            $table->string("url");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piecejointes');
    }
};
