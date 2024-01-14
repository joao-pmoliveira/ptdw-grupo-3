<?php

namespace Database\Seeders;

use App\Models\ACN;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\UnidadeCurricular;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class UnidadesCurricularesTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create();
        $ucs = [
            ['Inglês Técnico', 'IT'],
            ['Algoritmia e Programação', 'AP'],
            ['Introdução às Tecnologias Web', 'ITW'],
            ['Estruturas de Dados de Programação', 'EDP'],
            ['Sistemas de Base de Dados', 'SBD'],
            ['Elementos de Matemática', 'EM'],
            ['Gestão de Qualidade I', 'GQI'],
            ['Modelos da Qualidade', 'MQ'],
            ['Desenho Técnico', 'DT'],
            ['Eletromagnetismo Aplicado', 'F'],
            ['Métodos Numéricos e Estatísticos', 'MNE']

        ];

        $docentes = Docente::all()
            ->pluck('id')
            ->toArray();
        $numeroDocentes = count($docentes);
        $index = 0;

        foreach ($ucs as $uc) {
            $codigo = $faker->randomNumber(5);
            $nome = $uc[0];
            $sigla = $uc[1];
            $horas_semanais = $faker->randomElement([2, 4, 6]);
            $acn_id = ACN::pluck('id')->random();
            $ects = $faker->randomElement([4, 6]);
            $docente_responsavel_id = $docentes[$index];
            $restricoes_submetidas = $faker->boolean();
            $sala_laboratorio = $faker->boolean();
            $exame_final_laboratorio = $faker->boolean();
            $exame_recurso_laboratorio = $faker->boolean();
            $observacoes_laboratorios = $faker->text();
            $software = $faker->text();

            $numeroDocentesAssociados = $faker->randomElement([2, 3]);

            $docentesAssociados = [];
            for ($j = 0; $j < $numeroDocentesAssociados; $j++) {
                array_push($docentesAssociados, $docentes[($index + $j) % $numeroDocentes]);
            }

            $periodos_ids = Periodo::pluck('id')->all();
            $cursos = Curso::pluck('id')->random(1, 2);
            foreach ($periodos_ids as $periodo_id) {
                $ucPeriodo = UnidadeCurricular::factory()->create([
                    'codigo' => $codigo,
                    'sigla' => $sigla,
                    'periodo_id' => $periodo_id,
                    'nome' => $nome,
                    'acn_id' => $acn_id,
                    'horas_semanais' => $horas_semanais,
                    'ects' => $ects,
                    'docente_responsavel_id' => $docente_responsavel_id,
                    'restricoes_submetidas' => $restricoes_submetidas,
                    'sala_laboratorio' => $sala_laboratorio,
                    'exame_final_laboratorio' => $exame_final_laboratorio,
                    'exame_recurso_laboratorio' => $exame_recurso_laboratorio,
                    'observacoes_laboratorios' => $observacoes_laboratorios,
                    'software' => $software,
                ]);


                $ucPeriodo->docentes()->attach(
                    $docentesAssociados,
                    ['percentagem_semanal' => $ucPeriodo->horas_semanais / count($docentes)]
                );

                $ucPeriodo->cursos()->attach(
                    $cursos
                );
            }
            $index++;
        }
    }
}
