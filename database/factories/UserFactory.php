<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombres' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'edad' => $this->faker->numberBetween($min = 18, $max = 60),
            'cargo_id' => $this->faker->randomElement($array = array (2,3)),
            'cedula' => $this->faker->randomNumber($nbDigits = 10, $strict = false),
            'nocelular' => $this->faker->randomNumber($nbDigits = 10, $strict = false),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
