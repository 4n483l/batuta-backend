<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Models\Instrument;

class CourseFactory extends Factory
{
    protected $model = Course::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // fechas entre 2023 y 2025
        $date = $this->faker->dateTimeBetween('2023-01-01', '2025-12-31');

        // Asignar aleatoriamente subject_id o instrument_id
        $useSubjectInstrument = $this->faker->boolean(10);


        return [
           'subject_id' => $useSubjectInstrument ? Subject::factory() : null,
            'instrument_id' => !$useSubjectInstrument ? Instrument::factory() : null,
            'user_id' => User::factory(),
            'classroom' => $this->faker->word,
            'date' => $date->format('Y-m-d'),
            'hour' => $this->faker->time('H:i'),
        ];
    }
}
