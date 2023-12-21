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

        foreach ($ucs as $uc) {
            $codigo = $faker->randomNumber(5);
            $nome = $uc[0];
            $sigla = $uc[1];
            $horas_semanais = $faker->randomElement([2, 4, 6]);
            $acn_id = ACN::pluck('id')->random();
            $laboratorio = $faker->boolean();
            $software = $faker->text();
            $ects = $faker->randomElement([4, 6]);
            $sala_avaliacao = $faker->boolean();
            $docente_responsavel_id = Docente::pluck('id')->random();

            $periodos_ids = Periodo::pluck('id')->all();

            $docentes = Docente::pluck('id')->random(1, 2);
            $cursos = Curso::pluck('id')->random(1, 2);
        

            foreach ($periodos_ids as $periodo_id) {
                $ucPeriodo = UnidadeCurricular::factory()->create([
                    'codigo' => $codigo,
                    'periodo_id' => $periodo_id,
                    'nome' => $nome,
                    'sigla' => $sigla,
                    'acn_id' => $acn_id,
                    'horas_semanais' => $horas_semanais,
                    'laboratorio' => $laboratorio,
                    'software' => $software,
                    'ects' => $ects,
                    'sala_avaliacao' => $sala_avaliacao,
                    'docente_responsavel_id' => $docente_responsavel_id,
                ]); 
                
                $ucPeriodo->docentes()->attach(
                    $docentes, ['percentagem_semanal' => $ucPeriodo->horas_semanais / count($docentes)]
                );
                
                $ucPeriodo->cursos()->attach(
                    $cursos
                );                
            }
        }
    }
}
