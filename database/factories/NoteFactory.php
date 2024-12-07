<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Note;
use App\Models\User;
use App\Models\Subject;
use App\Models\Instrument;

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

        $useSubjectInstrument = $this->faker->boolean(50);
/*
        return [

            'subject_id' => $useSubjectInstrument ? Subject::factory() : null,
            'instrument_id' => !$useSubjectInstrument ? Instrument::factory() : null,
            'user_id' => User::where('user_type', 'teacher')->inRandomOrder()->first()->id,
            'title' => $this->faker->word,
            'topic' => $this->faker->word,
            'content' => $this->faker->text,

        ]; */

        return [

            'subject_id' => $useSubjectInstrument ? Subject::inRandomOrder()->first()->id : null,
            'instrument_id' => !$useSubjectInstrument ?Instrument ::inRandomOrder()->first()->id  : null,
            'user_id' => User::where('user_type', 'teacher')->inRandomOrder()->first()->id,
            'title' => $this->faker->word,
            'topic' => $this->faker->word,
            'content' => $this->faker->text,
        ];
    }
}
