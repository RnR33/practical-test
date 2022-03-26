<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(10,99),
            'dob' => $this->faker->date('Y-m-d'),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
