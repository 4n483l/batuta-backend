<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(10)->create();
        \App\Models\Concerts::factory(10)->create();
        \App\Models\Rehearsals::factory(10)->create();
        \App\Models\Classes::factory(10)->create();
         \App\Models\Exams::factory(10)->create();
         \App\Models\Notes::factory(10)->create();


        //crea datos a nivel memoria sin guardar en sql
        //  \App\Models\User::factory(10)->make();
        // \App\Models\Concerts::factory(10)->make();
        // \App\Models\Rehearsals::factory(10)->make();
        // \App\Models\Classes::factory(10)->make();
         //\App\Models\Exams::factory(10)->make();
        // \App\Models\Notes::factory(10)->make();

    }
}
