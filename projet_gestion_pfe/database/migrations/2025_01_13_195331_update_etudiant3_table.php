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
        Schema::table('etudiants', function (Blueprint $table) {
            // Add the column if it doesn't exist
            if (!Schema::hasColumn('etudiants', 'filiere_id')) {
                $table->foreignId('filiere_id') // Adds an unsigned BIGINT column
                      ->nullable() // Optional, make it nullable if needed
                      ->constrained('filieres') // Adds foreign key to 'filieres' table
                      ->onDelete('cascade');
            }
        });
    }
    
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropForeign(['filiere_id']); // Drops the foreign key constraint
            $table->dropColumn('filiere_id');   // Removes the column from the table
        });
    }
    
};
