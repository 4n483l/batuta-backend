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
        // \App\Models\User::factory(10)->create();
        \App\Models\Concerts::factory(10)->create();


        //crea datos a nivel memoria sin guardar en sql
        \App\Models\User::factory(10)->make();
        // \App\Models\Concerts::factory(10)->make();

    }
}
