<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Concerts;

class ConcertsFactory extends Factory
{
    protected $model = Concerts::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'place' => $this->faker->city,
            'date' => $this->faker->date,
            'hour' => $this->faker->time,
        ];
    }
}
