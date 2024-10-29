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
        $subjects = \App\Models\Subject::factory(5)->create();
        \App\Models\User::factory(5)->create()
            ->each(function ($user) use ($subjects) {
                $user->subjects()->attach(
                    $subjects->random(3)->pluck('id')->toArray()
                );
            });

         $rehearsals = \App\Models\Rehearsal::factory(5)->create();
        \App\Models\User::all()->each(function ($user) use ($rehearsals) {
            $user->rehearsals()->attach(
                $rehearsals->random(3)->pluck('id')->toArray()
            );
        });

        $concerts = \App\Models\Concert::factory(5)->create();
        \App\Models\User::all()->each(function ($user) use ($concerts) {
            $user->concerts()->attach(
                $concerts->random(3)->pluck('id')->toArray()
            );
        });


        \App\Models\Course::factory(10)->create();
        \App\Models\Exam::factory(10)->create();
        \App\Models\Note::factory(10)->create();


        //crea datos a nivel memoria sin guardar en sql
        //  \App\Models\User::factory(10)->make();
        // \App\Models\Concert::factory(10)->make();
        // \App\Models\Rehearsal::factory(10)->make();
        // \App\Models\Course::factory(10)->make();
        //\App\Models\Exam::factory(10)->make();
        // \App\Models\Note::factory(10)->make();
    }
}
