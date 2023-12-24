<?php

namespace Database\Factories;

use App\Models\ACN;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Docente>
 */
class DocenteFactory extends Factory
{
    public function definition(): array
    {
        $acns_ids = ACN::pluck('id')->toArray();

        $faker = FakerFactory::create('pt_PT');

        $name = $faker->name();

        return [
            'nome' => $name,
            'numero_funcionario' => fake()->unique()->randomNumber(4, true),
            'acn_id' => fake()->randomElement($acns_ids),
            'email' => strtolower(str_replace(' ', '.', $name)) . $faker->unique()->randomNumber(5, true) . "@estga.pt",
            'numero_telefone' => $faker->phoneNumber(),
        ];
    }
}
