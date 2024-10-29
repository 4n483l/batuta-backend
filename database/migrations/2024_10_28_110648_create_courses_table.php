<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->onDelete('cascade'); // Asignatura de la clase
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Profesor que imparte la clase
            $table->date('date'); // Fecha de la clase
            $table->string('hour'); // Hora de la clase
            $table->string('classroom')->nullable(); // Aula (opcional)
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
        Schema::dropIfExists('courses');
    }
}
