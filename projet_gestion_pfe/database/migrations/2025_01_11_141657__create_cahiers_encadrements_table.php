<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCahiersEncadrementsTable extends Migration
{
    public function up()
    {
        Schema::create('cahiers_encadrements', function (Blueprint $table) {
            $table->id();
            $table->date('date');             // Date of the planning
            $table->integer('duree'); 
            $table->string('commentaire')->nullable();        // Duration (in hours)
            $table->enum('emplacement', ['à distance', 'présentiel']); // Emplacement with two possible values
            $table->foreignId('stage_id')->constrained('stages')->onDelete('cascade'); // Foreign key for the stage
            $table->timestamps();             // Timestamps for created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('cahiers_encadrements');
    }
}
