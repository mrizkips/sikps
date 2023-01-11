<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'password' => 'password', // password
            'jk' => fake()->randomElement(['L', 'P']),
            'email' => fake()->safeEmail(),
            'no_hp' => fake()->phoneNumber(),
            'remember_token' => Str::random(10),
        ];
    }
}
