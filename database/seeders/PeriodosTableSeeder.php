<?php

namespace Database\Seeders;

use App\Models\Periodo;
use Database\Factories\PeriodoFactory;
use Illuminate\Database\Seeder;

class PeriodosTableSeeder extends Seeder
{
    public function run(): void
    {

        $periodos = [
            [2021, 1],
            [2021, 2],
            [2022, 1],
            [2022, 2],
            [2023, 1],
        ];

        foreach ($periodos as $index => $periodo) {
            $ano = $periodo[0];
            $semestre = $periodo[1];

            $datas = PeriodoFactory::gerarDatasPeriodo($ano, $semestre);

            $data_inicial = $datas['data_inicial'];
            $data_final = $datas['data_final'];

            Periodo::factory()->create([
                'ano' => $ano,
                'semestre' => $semestre,
                'data_inicial' => $data_inicial,
                'data_final' => $data_final,
            ]);
        }
    }
}
