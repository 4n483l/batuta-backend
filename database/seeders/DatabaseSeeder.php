<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Student;
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
        $subjects = Subject::factory(3)->create();

        // -----------------  EXAMS -----------------
        Exam::factory(10)->create();

        // COURSES -----------------
        Course::factory(10)->create();

        //----------------- STUDENTS -----------------
        $members->each(function ($member) use ($instruments, $subjects) {
            // Decidir aleatoriamente si este miembro tendrá estudiantes(1 o 2 Students)
            $numberOfStudents = rand(0, 2);
            if ($numberOfStudents > 0) {
                $students = Student::factory($numberOfStudents)->create([
                    'user_id' => $member->id, // Asignar el id del miembro
                ]);

                // Asociar instrumentos y asignaturas a los students
                $students->each(function ($student) use ($instruments, $subjects) {
                    // Asignar un instrumento aleatorio al student
                    $randomInstrument = $instruments->random();
                    $student->instruments()->attach($randomInstrument->id);

                    $randomSubjects = $subjects->random(rand(1, 2));
                    $student->subjects()->attach($randomSubjects->pluck('id')->toArray());
                });
            }
        });

        // ----------------- TEACHER-SUBJECT -----------------
        $teachers->each(function ($teacher) use ($subjects, $instruments) {
            // Seleccionar 2 asignaturas aleatorias para el teacher
            $randomSubjects = $subjects->random(2);
            // Asociar las asignaturas al teacher
            $teacher->subjects()->attach($randomSubjects->pluck('id')->toArray());

            // Seleccionar 1 instrumento aleatorio para el teacher
            $randomInstrument = $instruments->random();
        // Asociar el instrumento al teacher
        $teacher->instruments()->attach($randomInstrument->id);
    });


        // ----------------- USER-REHEARSAL -----------------
        User::where('user_type', 'musician')->each(function ($user) use ($rehearsals) {
            $user->rehearsals()->attach(
                $rehearsals->random(5)->pluck('id')->toArray()
            );
        });


        // ----------------- NOTES -----------------
        Note::factory(10)->create();







        //crea datos a nivel memoria sin guardar en sql
        //  \App\Models\User::factory(10)->make();
        // \App\Models\Concert::factory(10)->make();
        // \App\Models\Rehearsal::factory(10)->make();
        // \App\Models\Course::factory(10)->make();
        //\App\Models\Exam::factory(10)->make();
        // \App\Models\Note::factory(10)->make();
    }
}
