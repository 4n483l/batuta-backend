<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;

class StudentFactory extends Factory
{

    protected $model = Student::class;
    
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
            'dni' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'birth_date' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
