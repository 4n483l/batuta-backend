<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notes;

class NotesFactory extends Factory
{
    protected $model = Notes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'title' => $this->faker->word,
            'content' => $this->faker->text,
            'subject' => $this->faker->word,
        ];
    }
}
