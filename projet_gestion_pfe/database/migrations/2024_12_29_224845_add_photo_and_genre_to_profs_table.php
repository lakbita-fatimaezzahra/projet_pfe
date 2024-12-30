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
        Schema::table('profs', function (Blueprint $table) {
            $table->string('photo')->nullable(); // Chemin pour stocker la photo
            $table->enum('genre', ['Homme', 'Femme'])->nullable(); // Genre (Homme/Femme)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profs', function (Blueprint $table) {
            $table->dropColumn('photo');
            $table->dropColumn('genre');
        });
    }
};
