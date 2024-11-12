<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Note;
use App\Models\User;
use App\Models\Subject;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'subject_id' => Subject::factory(),
            'title' => $this->faker->word,
            'topic' => $this->faker->word,
            'content' => $this->faker->text,

        ];
    }
}
