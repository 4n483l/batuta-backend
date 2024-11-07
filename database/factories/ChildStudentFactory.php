<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChildStudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'birth_date' => $this->faker->date(),
            // 'user_id' => $this->faker->unique()->numberBetween(1, 5),
        ];
    }
}
