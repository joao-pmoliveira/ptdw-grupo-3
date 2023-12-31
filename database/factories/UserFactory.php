<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

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
    public function definition(): array
    {
        $faker = FakerFactory::create('pt_PT');

        $nome = $faker->name();


        return [
            'nome' => $nome,
            'email' => strtolower(str_replace(' ', '.', $nome)) . $faker->unique()->randomNumber(5, true) . "@estga.pt",
            'email_verficado_a' => now(),
            'password' => bcrypt('password'),
            'remember_token' => $faker->regexify('[a-zA-Z]{100}')
        ];
    }
}
