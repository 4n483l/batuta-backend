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
        return [
            'place' => $this->faker->randomElement(['auditorium', 'rehearsal room']),
            'date' => $this->faker->date,
            'hour' => $this->faker->time,
        ];
    }
}
