<?php

namespace Database\Factories;

use App\Models\Cv;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class CvFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber(),
            'description' => $this->faker->sentence(rand(2,3)),
            'done' => $this->faker->boolean(),
        ];
    }
}
