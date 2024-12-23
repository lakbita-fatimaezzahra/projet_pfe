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
        Schema::create('affectations', function (Blueprint $table) {
        $table->id(); // Identifiant unique
        $table->string('role'); // Champ "role" pour le rôle spécifique dans l'affectation
        $table->foreignId('prof_id')->constrained('profs')->onDelete('cascade'); // Référence à la table "profs"
        $table->foreignId('stage_id')->constrained('stages')->onDelete('cascade'); // Référence à la table "stages"
        $table->timestamps(); // Colonnes created_at et updated_at
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affectations');
    }
};
