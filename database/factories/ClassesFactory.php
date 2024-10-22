<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classes;

class ClassesFactory extends Factory
{
    protected $model = Classes::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'subject' => $this->faker->word,
            'teacher' => $this->faker->name,
            'classroom' => $this->faker->word,
            'date' => $this->faker->date,
            'hour' => $this->faker->time,
        ];
    }
}
