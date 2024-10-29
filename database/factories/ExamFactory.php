<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\User;

class ExamFactory extends Factory
{
    protected $model = Exam::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject_id' => Subject::factory(),
            'user_id' => User::factory(),
            'classroom' => $this->faker->word,
            'date' => $this->faker->date,
            'hour' => $this->faker->time,
        ];
    }
}
