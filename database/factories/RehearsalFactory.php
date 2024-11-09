<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Rehearsal;

class RehearsalFactory extends Factory
{
    protected $model = Rehearsal::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        // fechas entre 2023 y 2025
        $date = $this->faker->dateTimeBetween('2023-01-01', '2025-12-31');

        return [
            'place' => $this->faker->randomElement(['auditorium', 'rehearsal room']),
            'date' => $date->format('Y-m-d'),
            'hour' => $this->faker->time('H:i'),
        ];
    }
}
