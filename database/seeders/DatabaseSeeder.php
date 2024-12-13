<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
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


        $this->call([
            UserSeeder::class,
            ConcertSeeder::class,
            RehearsalSeeder::class,
        ]);

        // ----------------- SUBJECTS-----------------
        $subjectNames = ['Lenguaje Musical', 'Jardín Musical', 'Canto vocal'];
        $subjects = collect($subjectNames)->map(function ($name) {
            return Subject::create(['name' => $name]);
        });

        // ----------------- INSTRUMENTS -----------------
        $instrumentNames = ['Trompa', 'Saxofón', 'Clarinete', 'Flauta', 'Trompeta', 'Piano', 'Guitarra', 'Violín', 'Percusión', 'Trombón', 'Tuba', 'Bombardino', 'Contrabajo', 'Violonchelo', 'Acordeón', 'Armónica'];
        $instruments = collect($instrumentNames)->map(function ($name) {
            return Instrument::create(['name' => $name]);
        });

        // ----------- INSTRUMENT-MUSICIAN -----------------
        $musicians = User::where('user_type', 'musician')->get();

        $musicians->each(function ($musician) use ($instruments) {
            $musician->instruments()->attach($instruments->random()->id, ['user_type' => 'musician']);
        });

        // ----------- INSTRUMENT-TEACHER-----------------
        $teachers = User::where('user_type', 'teacher')->get();
        $teachers->each(function ($teacher) use ($instruments) {
            // $randomInstrument = $instruments->random();
            $teacher->instruments()->attach($instruments->random()->id, ['user_type' => 'teacher']);
        });

        // ----------------- TEACHER-SUBJECT -----------------
        $teachers->each(function ($teacher) use ($subjects, $instruments) {
            // Seleccionar 2 asignaturas aleatorias para el teacher
            $randomSubjects = $subjects->random(rand(1, 2));
            $randomInstrument = $instruments->random();

            $teacher->subjects()->attach(
                $randomSubjects->pluck('id')->toArray(),
                ['user_type' => 'teacher']
            );
            $teacher->instruments()->attach($randomInstrument->id, ['user_type' => 'teacher']);
        });


        //----------------- STUDENTS -----------------

        $studentsData = [
            [
                'name' => 'Alba',
                'lastname' => 'Navarro Verde',
                'phone' => '555444777',
                'address' => 'Calle Menor, 7',
                'city' => 'Benidorm',
                'postal_code' => '03500',
                'birth_date' => '2020-03-02',
                'email' => 'student1@example.com',

            ],
            [
                'name' => 'Irina',
                'lastname' => 'Jiganie',
                'phone' => '553444777',
                'address' => 'Calle Almedia, 45',
                'city' => 'Callosa',
                'postal_code' => '03510',
                'birth_date' => '2017-07-26',
                'email' => 'student2@example.com',

            ],
            [
                'name' => 'Marcos',
                'lastname' => 'Ferrer Torralbo',
                'phone' => '555444779',
                'address' => 'Calle Alamo, 7',
                'city' => 'Benidorm',
                'postal_code' => '03500',
                'birth_date' => '2021-06-02',
                'email' => 'student3@example.com',

            ],
            [
                'name' => 'Manuela',
                'lastname' => 'Ferrer Ferrer',
                'phone' => '525444779',
                'address' => 'Calle Corazon, 7',
                'city' => 'Benidorm',
                'postal_code' => '03500',
                'birth_date' => '2015-10-25',
                'email' => 'student4@example.com',

            ],
            [
                'name' => 'Doris',
                'lastname' => 'Stutgart',
                'phone' => '555844779',
                'address' => 'Calle Paseo, 21',
                'city' => 'Benidorm',
                'postal_code' => '03500',
                'birth_date' => '1985-06-14',
                'email' => 'student5@example.com',

            ]
                ];


        $studentsCollection = collect($studentsData); // Convertir el array en una colección
        $members = User::where('user_type','member')->  get();

        $members->each(function ($member) use ($studentsCollection, $instruments, $subjects) {
            $numberOfStudents = rand(0, 2);

            // Elimina los estudiantes de la colección y los guarda en una nueva colección
            $studentsForMember = $studentsCollection->splice(0, $numberOfStudents);

            $studentsForMember->each(function ($studentData) use ($member, $instruments, $subjects) {
                // Crear el estudiante asociado al miembro
                $student = Student::create(array_merge($studentData, [
                    'user_id' => $member->id,
                ]));

                // Asignar un instrumento aleatorio al estudiante
                $randomInstrument = $instruments->random();
                $student->instruments()->attach($randomInstrument->id);

                // Asignar 1 o 2 asignaturas aleatorias al estudiante
                $randomSubjects = $subjects->random(rand(1, 2));
                $student->subjects()->attach($randomSubjects->pluck('id')->toArray());
    });
});



        // -----------------  EXAMS ----------------

        for ($i = 0; $i < 10; $i++) {

            $teacher = $teachers->random();
            $isSubjectExam = rand(0, 1) == 0;

            if ($isSubjectExam) {
                $subject = $subjects->random();
                Exam::create([
                    'subject_id' => $subject->id,
                    'user_id' => $teacher->id,
                    'instrument_id' => null,
                    'date' => $this->generateRandomDate(),
                    'hour' => $this->generateRandomHour(),
                    'classroom' => $this->generateRandomClassroom(),
                ]);
            } else {
                $instrument = $instruments->random();
                Exam::create([
                    'subject_id' => null,
                    'user_id' => $teacher->id,
                    'instrument_id' => $instrument->id,
                    'date' => $this->generateRandomDate(),
                    'hour' => $this->generateRandomHour(),
                    'classroom' => $this->generateRandomClassroom(),
                ]);
            }
        }

        // ---------------- COURSES -----------------
        for ($i = 0; $i < 10; $i++) {

            $teacher = $teachers->random();
            $isSubjectCourse = rand(0, 1) == 0;

            if ( $isSubjectCourse) {
                $subject = $subjects->random();
                Course::create([
                    'subject_id' => $subject->id,
                    'user_id' => $teacher->id,
                    'instrument_id' => null,
                    'date' => $this->generateRandomDate(),
                    'hour' => $this->generateRandomHour(),
                    'classroom' => $this->generateRandomClassroom(),
                ]);
            } else {
                $instrument = $instruments->random();
                Course::create([
                    'subject_id' => null,
                    'user_id' => $teacher->id,
                    'instrument_id' => $instrument->id,
                    'date' => $this->generateRandomDate(),
                    'hour' => $this->generateRandomHour(),
                    'classroom' => $this->generateRandomClassroom(),
                ]);
            }
        }

        // ----------------- NOTES -----------------


        for ($i = 0; $i < 10; $i++) {

            $teacher = $teachers->random();

            // Aleatoriamente seleccionar si el apunte tendrá un subject_id o un instrument_id
            $subject = $subjects->isNotEmpty() ? $subjects->random() : null;
            $instrument = $instruments->isNotEmpty() ? $instruments->random() : null;

            // Asegurarse de que solo uno de los dos esté presente
            if ($subject && $instrument) {
                $instrument = null; // Eliminar instrumento si ya hay un subject
            }
            // Crear el apunte
            Note::create([
                'title' => 'Apunte ' . ($i + 1),
                'topic' => 'Tema ' . rand(1, 5), // Tema aleatorio
                'content' => 'Contenido del apunte para el tema ' . rand(1, 5),
                'user_id' => $teacher->id,
                'subject_id' => $subject ? $subject->id : null,
                'instrument_id' => $instrument ? $instrument->id : null,
                'pdf' => null, 
            ]);
        }



    }

    private function generateRandomDate()
    {
        // Generar una fecha aleatoria dentro de los próximos 3 meses
        return now()->addDays(rand(1, 90))->format('Y-m-d');
    }
    private function generateRandomHour()
    {
        // Generar una hora aleatoria entre 15:00 y 20:00
        return rand(15, 20) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
    }
    private function generateRandomClassroom()
    {
        $classrooms = ['Aula 101', 'Aula 102', 'Aula 103', 'Sala 1', 'Sala 2'];
        return $classrooms[array_rand($classrooms)];
    }
}
