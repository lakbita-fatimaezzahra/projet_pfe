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
        Schema::table('stages', function (Blueprint $table) {

            // Rendre la colonne 'etudiant_id' unique
            $table->unique('etudiant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            // Supprimer la contrainte unique et la clé étrangère
            $table->dropUnique(['etudiant_id']);

        });
    }
};
