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
        Schema::table('encadrements', function (Blueprint $table) {
            // Make salle_id nullable to avoid errors with invalid data
            $table->foreignId('salle_id')->nullable()->constrained('salles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cahiers_encadrements', function (Blueprint $table) {
            // Drop the foreign key and make salle_id non-nullable
            $table->dropForeign(['salle_id']);
            $table->foreignId('salle_id')->constrained('salles')->onDelete('cascade');
        });
    }
};
