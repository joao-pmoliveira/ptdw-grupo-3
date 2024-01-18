<?php

namespace Database\Seeders;

use App\Models\Periodo;
use Database\Factories\PeriodoFactory;
use Illuminate\Database\Seeder;

class PeriodosTableSeeder extends Seeder
{
    public function run(): void
    {
        $ano_inicial = 2023;
        $anos = 3;

        for ($i = 0; $i < $anos; $i++) {
            $ano = $ano_inicial - $i;

            for ($semestre = 1; $semestre < 3; $semestre++) {

                $datas = PeriodoFactory::gerarDatasPeriodo($ano, $semestre);

                $data_inicial = $datas['data_inicial'];
                $data_final = $datas['data_final'];

                Periodo::factory()->create([
                    'ano' => $ano,
                    'semestre' => $semestre,
                    'data_inicial' => $data_inicial,
                    'data_final' => $data_final
                ]);
            }
        }
    }
}
