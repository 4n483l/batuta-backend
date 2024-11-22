<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ChildStudent;
use App\Models\Subject;
use App\Models\Rehearsal;
use App\Models\Concert;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Note;
use App\Models\Instrument;


class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // ----------------- USERS -----------------------
        $users = User::factory(5)->create();

        // ----------------- REHEARSALS -----------------
        $rehearsals =
            Rehearsal::factory(20)->create();

        // ----------------- CONCERTS-----------------
        Concert::factory(10)->create();

        // ----------------- INSTRUMENTS -----------------
        Instrument::factory(5)->create();


        // ----------------- SUBJECTS-----------------
        $subjects = Subject::factory(5)->create();

        // ----------------- SUBJECT-CHILD -----------------

        






        $students = ChildStudent::where('user_type', 'student')->get();

        $students->each(function ($user) use ($subjects) {
            // Obtener la asignatura Instrumento asegurando que existe
            $instrumentSubject  = Subject::firstOrCreate(
                ['name' => 'Instrumento'],
                ['level' => 'Básico']
            );

            // asigna Instrumento y otra aleatoria al estudiante
            $otherSubject = $subjects->where('name', '!=', 'Instrumento')->random();
            $user->subjects()->attach([$instrumentSubject->id, $otherSubject->id]);

            // obtener un instrumento de la asignatura "Instrumento"
            $instrument = Instrument::where('subject_id', $instrumentSubject->id)->get();

            // Asocia ese instrumento al usuario en la asignatura "Instrumento"
            if ($instrument->count() > 0) {

                $randomInstrument = $instrument->random();
                $user->instruments()->attach($randomInstrument->id, [
                    'subject_id' => $instrumentSubject->id,
                'user_id' => $user->id,
                ]);
            }
        });

        // ----------------- NOTES -----------------
        Note::factory(10)->create();
        Note::factory(10)->create([
            'user_id' => $users->random()->id,
            'subject_id' => $subjects->random()->id,
        ]);

        // -----------------  EXAMS -----------------
        Exam::factory(10)->create();

        // COURSES -----------------
        Course::factory(10)->create();

        //----------------- CHILDSTUDENTS -----------------
        $users->each(function ($user) {
            ChildStudent::factory(5)->create([
                'user_id' => $user->id, // Asignar el id del usuario a cada ChildStudent
            ]);
        });

        // ----------------- CHILDSTUDENT-SUBJECT -----------------
        ChildStudent::all()->each(function ($childStudent) use ($subjects) {
            $childStudent->subjects()->attach(
                $subjects->random(3)->pluck('id')->toArray()
            );
        });

        // ----------------- USER-REHEARSAL -----------------
        User::where('user_type', 'musician')->each(function ($user) use ($rehearsals) {
            $user->rehearsals()->attach(
                $rehearsals->random(3)->pluck('id')->toArray()
            );
        });



        //crea datos a nivel memoria sin guardar en sql
        //  \App\Models\User::factory(10)->make();
        // \App\Models\Concert::factory(10)->make();
        // \App\Models\Rehearsal::factory(10)->make();
        // \App\Models\Course::factory(10)->make();
        //\App\Models\Exam::factory(10)->make();
        // \App\Models\Note::factory(10)->make();
    }
}
