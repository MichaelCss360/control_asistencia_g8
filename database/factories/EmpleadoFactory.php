<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoFactory extends Factory
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
            'cedula' => $this->faker->randomNumber($nbDigits = NULL, $strict = false),
            'nocelular' => $this->faker->randomNumber($nbDigits = NULL, $strict = false),
        ];
    }
}
