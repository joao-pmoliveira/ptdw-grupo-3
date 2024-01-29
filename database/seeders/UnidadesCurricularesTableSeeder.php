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
        $periodos = Periodo::all();

        $docentes = Docente::all()->shuffle();

        foreach ($ucs as $uc) {
            $nome = $uc[0];
            $sigla = $uc[1];
            $codigo = $faker->randomNumber(5, true);
            $horasSemanais = $faker->randomElement([2, 4, 6]);
            $acnId = ACN::pluck('id')->random();
            $ects = $faker->randomElement([4, 6]);

            $salaLaboratorio = $faker->boolean();
            $exameFinalLaboratorio = $salaLaboratorio ? $faker->boolean() : false;
            $exameRecursoLaboratorio = $exameFinalLaboratorio;
            $observacoesLaboratorios = $faker->text();
            $software = $faker->text();

            $cursos = Curso::pluck('id')->random(1, 2);

            foreach ($periodos as $periodo) {
                $ucRecord = UnidadeCurricular::create([
                    "codigo" => $codigo,
                    "sigla" => $sigla,
                    "nome" => $nome,
                    "periodo_id" => $periodo->id,
                    "acn_id" => $acnId,
                    "horas_semanais" => $horasSemanais,
                    "ects" => $ects,
                    // "docente_responsavel_id" => NULL,
                    "restricoes_submetidas" => true,
                    "sala_laboratorio" => $salaLaboratorio,
                    "exame_final_laboratorio" => $exameFinalLaboratorio,
                    "exame_recurso_laboratorio" => $exameRecursoLaboratorio,
                    "observacoes_laboratorios" => $observacoesLaboratorios,
                    "software" => $software,
                ]);

                $responsavel = $docentes->pop();
                $responsavel->ucsResponsavel()->save($ucRecord);

                $docentesAdicionais = $faker->numberBetween(1, 2);
                // todo @joao: possível que o cálculo tenha que ser repensado
                $percentagem = round($ucRecord->horas_semanais / ($docentesAdicionais + 1) / $ucRecord->horas_semanais, 2);
                foreach ($docentes->random($docentesAdicionais) as $doc) {
                    $doc->unidadesCurriculares()->attach($ucRecord->id, ["percentagem_semanal" => $percentagem]);
                }
                $responsavel->unidadesCurriculares()->attach($ucRecord->id, ["percentagem_semanal" => $percentagem]);

                $docentes->prepend($responsavel);

                $ucRecord->cursos()->attach($cursos);
            }
        }
    }
}
