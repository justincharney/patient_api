<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PatientsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'birthday' => fake()->dateTimeBetween('1920-01-01', '2000-12-31')->format('d/m/Y'),
            'sex' => fake()->randomElement(['M', 'F']),
            'weight' => fake()->numberBetween(75, 375),
            'height' =>fake()->randomElement(["5'0", "5'4", "6'0", "6'7", "5'8", "5'11", "4'9", "6'2"])
        ];
    }
}
