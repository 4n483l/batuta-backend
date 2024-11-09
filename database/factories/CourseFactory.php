<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;

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

        return [
           'subject_id' => Subject::factory(),
            'user_id' => User::factory(),
            'classroom' => $this->faker->word,
            'date' => $date->format('Y-m-d'),
            'hour' => $this->faker->time('H:i'),
        ];
    }
}
