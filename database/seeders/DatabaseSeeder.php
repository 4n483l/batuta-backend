<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ChildStudent;
use App\Models\Subject;


class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Crear 5 usuarios
        $users = User::factory(5)->create();

        // Crear 5 ChildStudents y asignarles el user_id de un usuario existente
        $users->each(function ($user) {
            ChildStudent::factory(5)->create([
                'user_id' => $user->id, // Asignar el id del usuario a cada ChildStudent
            ]);
        });

        $subjects = Subject::factory(5)->create();

        // Asignar asignaturas a usuarios
        $users->each(function ($user) use ($subjects) {
            $user->subjects()->attach(
                $subjects->random(3)->pluck('id')->toArray()
            );
        });
        // Asignar asignaturas a ChildStudents
        ChildStudent::all()->each(function ($childStudent) use ($subjects) {
            $childStudent->subjects()->attach(
                $subjects->random(3)->pluck('id')->toArray()
            );
        });
/*

        $subjects = \App\Models\Subject::factory(5)->create();
        $users= \App\Models\User::factory(5)->create()
            ->each(function ($user) use ($subjects) {
                $user->subjects()->attach(
                    $subjects->random(3)->pluck('id')->toArray()
                );
            });

        $subjects = \App\Models\Subject::factory(5)->create();

        \App\Models\ChildStudent::factory(5)->create()
            ->each(function ($childStudent) use ($subjects, $users) {
            $childStudent->user_id = $users->random()->id; // Asigna un solo usuario
            $childStudent->save();


                $childStudent->subjects()->attach(
                    $subjects->random(3)->pluck('id')->toArray()
            );
            // $childStudent->child()->associate($users->random());


            });
 */
/*


        $children = \App\Models\ChildStudent::factory(5)->create();
        \App\Models\User::all()->each(function ($user) use ($children) {
            $user->$children()->attach(
                $children->random(3)->pluck('id')->toArray()
            );
        });
 */

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
