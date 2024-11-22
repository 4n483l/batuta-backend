<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Instrument;
use App\Models\Subject;

class InstrumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Instrument::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'child_student_id' => $this->faker->unique()->numberBetween(1, 100),

            'subject_id' => Subject::firstOrCreate(
                ['name' => 'Instrumento'], // Asegura que "Instrumentos" exista
                ['level' => 'Básico'] // Puedes ajustar el nivel si es necesario
            )->id,
        ];
    }
}
