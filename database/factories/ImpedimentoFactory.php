<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Impedimento>
 */
class ImpedimentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'periodo_id' => fake()->numberBetween(0,3),
            'docente_id' => fake()->numberBetween(0,10),
            'impedimentos' => $this->generateImpedimentos(),
            'justificacao' => fake()->text(),
        ];
    }

    function generateImpedimentos() {
        $result = "";

        for( $i = 0; $i < 6; $i++) {
            for($j = 0; $j < 3; $j) {
                $randomNumber = rand(0,100)/100;
                $result .= $randomNumber;
                if ($i != 2) {
                    $result .= ',';
                }
            }
            $result .= ';';
        }

        return $result;
    }
}
