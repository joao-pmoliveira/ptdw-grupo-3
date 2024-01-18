<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Periodo>
 */
class PeriodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ano' => fake()->year(),
            'semestre' => fake()->numberBetween(1, 2),
            'data_inicial' => fake()->date(),
            'data_final' => fake()->date()
        ];
    }

    public static function gerarDatasPeriodo($ano, $semestre)
    {
        $data_inicial = $semestre == 1 ?
            fake()->dateTimeBetween("$ano-08-01", "$ano-08-20")->format("Y-m-d") :
            fake()->dateTimeBetween("$ano-11-15", "$ano-11-30")->format("Y-m-d");

        $data_final = $semestre == 1 ?
            fake()->dateTimeBetween("{$ano}-09-01", "{$ano}-09-07")->format("Y-m-d") :
            fake()->dateTimeBetween(($ano + 1) . "-02-01", ($ano + 1) . "-02-05")->format("Y-m-d");

        return ['data_inicial' => $data_inicial, 'data_final' => $data_final];
    }
}
