<?php

namespace Database\Seeders;

use App\Models\Periodo;
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

                $data_inicial = $semestre == 1 ?
                    fake()->dateTimeBetween("$ano-08-01", "$ano-08-20")->format("Y-m-d") :
                    fake()->dateTimeBetween("$ano-11-15", "$ano-11-30")->format("Y-m-d");

                $data_final = $semestre == 1 ?
                    fake()->dateTimeBetween("{$ano}-09-01", "{$ano}-09-07")->format("Y-m-d") :
                    fake()->dateTimeBetween(($ano + 1) . "-02-01", ($ano + 1) . "-02-05")->format("Y-m-d");

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
