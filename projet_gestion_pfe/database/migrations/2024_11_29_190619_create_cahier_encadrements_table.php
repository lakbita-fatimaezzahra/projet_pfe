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
        Schema::create('cahiers_encadrement', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('note');
            $table->text('commentaire')->nullable();
            $table->string('emplacement')->nullable();
            $table->integer('duree');
            $table->foreignId('stage_id')->constrained('stages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cahier_encadrements');
    }
};
