<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Concert;

class ConcertFactory extends Factory
{
    protected $model = Concert::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'place' => $this->faker->city,
            'date' => $this->faker->date,
            'hour' => $this->faker->time,
        ];
    }
}
