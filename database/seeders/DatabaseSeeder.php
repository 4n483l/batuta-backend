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

        // ----------------- ADMIN -----------------------
        User::factory()->create([
            'name' => 'Paco',
            'lastname' => 'Rovira',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'user_type' => 'admin',
            'password' => bcrypt('example'),
        ]);


        // ----------------- USERS -----------------------

        $musicians = User::factory(5)->create(['user_type' => 'musician']);
        $teachers = User::factory(5)->create(['user_type' => 'teacher']);
        $members = User::factory(5)->create(['user_type' => 'member']);

        $users = $musicians->concat($teachers)->concat($members);

        // ----------------- REHEARSALS -----------------
        $rehearsals = Rehearsal::factory(20)->create();

        // ----------------- CONCERTS-----------------
        Concert::factory(10)->create();

        // ----------------- SUBJECTS-----------------
        $subjectNames = ['Lenguaje Musical', 'Jardín Musical', 'Canto vocal'];
        $subjects = collect($subjectNames)->map(function ($name) {
            return Subject::factory()->create(['name' => $name]);
        });
        // $subjects = Subject::factory(3)->create();

        // ----------------- INSTRUMENTS -----------------
        $instrumentNames = ['Clarinete',  'Saxofón', 'Flauta', 'Trompeta', 'Trompa', 'Piano', 'Guitarra', 'Violín', 'Percusión','Trombón', 'Tuba', 'Bombardino', 'Contrabajo', 'Violonchelo', 'Acordeón', 'Armónica'];
        $instruments = collect($instrumentNames)->map(function ($name) {
            return Instrument::factory()->create(['name' => $name]);
        });
       // $instruments = Instrument::factory(3)->create();

        // -----------------  EXAMS -----------------
        Exam::factory(10)->create();

        // ---------------- COURSES -----------------
        Course::factory(10)->create();

        // ----------------- NOTES -----------------
        Note::factory(1)->create();


        // ----------- INSTRUMENT-MUSICIAN -----------------
        $musicians->each(function ($musician) use ($instruments) {
           // $randomInstrument = $instruments->random();
            $musician->instruments()->attach( $instruments->random()->id, ['user_type' => 'musician']);
        });
        // ----------- INSTRUMENT-TEACHER-----------------
        $teachers->each(function ($teacher) use ($instruments) {
           // $randomInstrument = $instruments->random();
            $teacher->instruments()->attach( $instruments->random()->id, ['user_type' => 'teacher']);
        });


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
            $randomSubjects = $subjects->random(1,2);
            $randomInstrument = $instruments->random();

            $teacher->subjects()->attach(
                $randomSubjects->pluck('id')->toArray(),
                ['user_type' => 'teacher']
            );
            $teacher->instruments()->attach($randomInstrument->id, ['user_type' => 'teacher']);


        });


        // ----------------- USER-REHEARSAL -----------------
        $musicians->each(function ($musician) use ($rehearsals) {
            $musician->rehearsals()->attach($rehearsals->random(5)->pluck('id')->toArray());
        });

   /*      User::where('user_type', 'musician')->each(function ($user) use ($rehearsals) {
            $user->rehearsals()->attach(
                $rehearsals->random(5)->pluck('id')->toArray()
            );
        }) */;







        //crea datos a nivel memoria sin guardar en sql
        //  \App\Models\User::factory(10)->make();
        // \App\Models\Concert::factory(10)->make();
        // \App\Models\Rehearsal::factory(10)->make();
        // \App\Models\Course::factory(10)->make();
        //\App\Models\Exam::factory(10)->make();
        // \App\Models\Note::factory(10)->make();
    }
}
