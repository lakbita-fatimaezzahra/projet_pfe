<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cahiers_encadrements', function (Blueprint $table) {
            // Drop the 'duree' column
            $table->dropColumn('duree');

            // Add 'heure_debut' and 'heure_fin' columns
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('cahiers_encadrements', function (Blueprint $table) {
            // Add 'duree' column back
            $table->integer('duree')->nullable();

            // Drop the 'heure_debut' and 'heure_fin' columns
            $table->dropColumn(['heure_debut', 'heure_fin']);
        });
    }
}
;
