<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->onDelete('cascade'); // Relación con la asignatura
            $table->foreignId('user_id')->constrained()->onDelete('cascade');    // Profesor que programa el examen
            $table->date('date');   // Fecha del examen
            $table->time('time');   // Hora del examen
            $table->string('classroom')->nullable(); // Aula donde se realizará el examen (opcional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
