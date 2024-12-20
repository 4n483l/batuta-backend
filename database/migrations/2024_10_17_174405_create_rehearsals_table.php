<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRehearsalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { // ensayos
        Schema::create('rehearsals', function (Blueprint $table) {
            $table->id();
            $table->enum('place', ['Auditorio', 'Sala de ensayo'])->default('Auditorio');
           // $table->string('place');
            $table->date('date');
            $table->string('hour');
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
        Schema::dropIfExists('rehearsals');
    }
}
