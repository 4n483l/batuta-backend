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


class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // USERS
        $users = User::factory(5)->create();

        // REHEARSALS
        $rehearsals = Rehearsal::factory(20)->create();

        // CONCERTS
        Concert::factory(10)->create();

        // SUBJECTS
        $subjects = Subject::factory(5)->create();

        // NOTES
        Note::factory(10)->create();
        Note::factory(10)->create([
            'user_id' => $users->random()->id,
            'subject_id' => $subjects->random()->id,
        ]);

        // SUBJECT-USER
        $students = User::where('user_type', 'student')->get();
        $students->each(function ($user) use ($subjects) {
            $user->subjects()->attach(
                $subjects->random(3)->pluck('id')->toArray()
            );
        });

        // EXAMS
        Exam::factory(10)->create();

        // COURSES
        Course::factory(10)->create();

        // CHILDSTUDENTS
        $users->each(function ($user) {
            ChildStudent::factory(5)->create([
                'user_id' => $user->id, // Asignar el id del usuario a cada ChildStudent
            ]);
        });

        // CHILDSTUDENT-SUBJECT
        ChildStudent::all()->each(function ($childStudent) use ($subjects) {
            $childStudent->subjects()->attach(
                $subjects->random(3)->pluck('id')->toArray()
            );
        });

        // USER-REHEARSAL
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
