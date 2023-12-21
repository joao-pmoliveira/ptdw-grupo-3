<?php

namespace Database\Seeders;

use App\Models\Docente;
use App\Models\Impedimento;
use App\Models\Periodo;
use Database\Factories\ImpedimentoFactory;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class ImpedimentosTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create();
        $docentes_ids = Docente::pluck('id')->all();
        $periodos_ids = Periodo::orderBy('data_final', 'desc')->pluck('id')->all();

        foreach ($docentes_ids as $docente_id) {
            foreach ($periodos_ids as $periodo_id) {
                Impedimento::factory()->create([
                    'periodo_id' => $periodo_id,
                    'docente_id' => $docente_id,
                    'impedimentos' => ImpedimentoFactory::generateImpedimentos(),
                    'justificacao' => $faker->text(),
                ]);
            }
        }

    }
}
