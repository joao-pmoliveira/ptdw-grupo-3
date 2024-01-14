<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use function PHPSTORM_META\map;

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
            'codigo' => fake()->numberBetween(0, 10),
            'sigla' => fake()->lexify('???'),
            'periodo_id' => fake()->numberBetween(0, 10),
            'nome' => fake()->name(),
            'acn_id' => fake()->numberBetween(0, 10),
            'horas_semanais' => fake()->numberBetween(0, 8),
            'ects' => fake()->numberBetween(0, 16),
            'docente_responsavel_id' => fake()->numberBetween(0, 10),
            'restricoes_submetidas' => fake()->boolean(),
            'sala_laboratorio' => fake()->boolean(),
            'exame_final_laboratorio' => fake()->boolean(),
            'exame_recurso_laboratorio' => fake()->boolean(),
            'observacoes_laboratorios' => fake()->boolean(),
            'software' => fake()->text(),
        ];
    }
}
