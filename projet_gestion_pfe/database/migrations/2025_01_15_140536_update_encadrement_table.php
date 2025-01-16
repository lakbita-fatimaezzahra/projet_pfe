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
        Schema::table('Salles', function (Blueprint $table) {
        $table->foreignId('salle_id')->constrained('salles')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Salles', function (Blueprint $table) {
            $table->dropforeign('salle_id')->constrained('salles')->onDelete('cascade'); 
        });
    }
};
