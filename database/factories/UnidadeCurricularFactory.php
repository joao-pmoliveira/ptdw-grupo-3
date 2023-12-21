<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnidadeCurricular>
 */
class UnidadeCurricularFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => fake()->numberBetween(0,10),
            'periodo_id' => fake()->numberBetween(0,10),
            'nome' => fake()->name(),
            'acn_id' => fake()->numberBetween(0,10),
            'horas_semanais' => fake()->numberBetween(0,8),
            'laboratorio' => fake()->boolean(),
            'software' => fake()->text(),
            'ects' => fake()->numberBetween(0, 16),
            'sala_avaliacao' => fake()->boolean(),
            'docente_responsavel_id' => fake()->numberBetween(0,10)
        ];
    }
}
