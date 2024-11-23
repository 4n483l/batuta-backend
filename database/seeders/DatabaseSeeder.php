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
        // $users = User::factory(5)->create();
        $musicians = User::factory(3)->create(['user_type' => 'musician']);
        $teachers = User::factory(3)->create(['user_type' => 'teacher']);
        $members = User::factory(3)->create(['user_type' => 'member']);

        $users = $musicians->concat($teachers)->concat($members);

        // ----------------- REHEARSALS -----------------
        $rehearsals = Rehearsal::factory(20)->create();

        // ----------------- CONCERTS-----------------
        Concert::factory(10)->create();

        // ----------------- INSTRUMENTS -----------------
        $instruments = Instrument::factory(5)->create();


        // ----------------- SUBJECTS-----------------
        $subjects = Subject::factory(5)->create();

        // -----------------  EXAMS -----------------
        Exam::factory(10)->create();

        // COURSES -----------------
        Course::factory(10)->create();

        //----------------- CHILDSTUDENTS -----------------
        $members->each(function ($member) use ($instruments, $subjects) {
            // Decidir aleatoriamente si este miembro tendrá hijos (1 o 2 ChildStudents)
            $numberOfChildren = rand(0, 2);
            if ($numberOfChildren > 0) {
                $childStudents = ChildStudent::factory($numberOfChildren)->create([
                    'user_id' => $member->id, // Asignar el id del miembro
                ]);



                // Asociar instrumentos y asignaturas a los ChildStudents
                $childStudents->each(function ($childStudent) use ($instruments, $subjects) {
                    // Asignar un instrumento aleatorio al ChildStudent
                    $randomInstrument = $instruments->random();



                    $childStudent->instruments()->attach($randomInstrument->id);

                    // Asignar hasta 2 asignaturas aleatorias al ChildStudent
                    $randomSubjects = $subjects->random(rand(1, 2)); // Puede asignarse 1 o 2 asignaturas
                    $childStudent->subjects()->attach($randomSubjects->pluck('id')->toArray());
                });
            }
        });

        // ----------------- USER-REHEARSAL -----------------
        User::where('user_type', 'musician')->each(function ($user) use ($rehearsals) {
            $user->rehearsals()->attach(
                $rehearsals->random(5)->pluck('id')->toArray()
            );
        });


        // ----------------- NOTES -----------------
        Note::factory(10)->create();
        Note::factory(10)->create([
            'user_id' => $users->random()->id,
            'subject_id' => $subjects->random()->id,
        ]);






        //crea datos a nivel memoria sin guardar en sql
        //  \App\Models\User::factory(10)->make();
        // \App\Models\Concert::factory(10)->make();
        // \App\Models\Rehearsal::factory(10)->make();
        // \App\Models\Course::factory(10)->make();
        //\App\Models\Exam::factory(10)->make();
        // \App\Models\Note::factory(10)->make();
    }
}
