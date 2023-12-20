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
}
