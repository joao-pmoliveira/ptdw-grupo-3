<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ACN;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\UnidadeCurricular;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'uc-data-file' => 'required|mimes:xlsx|max:10240',
            'file-start-year' => 'required|numeric|gte:2023',
            'file-semestre' => 'required|numeric|in:1,2'
        ]);

        $ano = $request->input('file-start-year');
        $semestre = $request->input('file-semestre');
        $file = $request->file('uc-data-file');

        // return response()->json([
        //     'ano' => $ano_inicial,
        //     'semestre' => $semestre
        // ]);

        $reader = IOFactory::createReaderForFile($file);
        $reader->setReadDataOnly(true);
        $spreasheet = $reader->load($file);
        $worksheet = $spreasheet->getActiveSheet();

        $data = [];

        foreach ($worksheet->getRowIterator() as $index => $row) {
            if ($index < 3) {
                // assume que as duas primeiras linhas são ocupadas por:
                // 1 -> cabeçalho
                // 2 -> linha em branco
                // como no ficheiro exemplo fornecido
                continue;
            }

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);

            $columnsMap = [
                'A' => 'numero_docente',
                'B' => 'nome_docente',
                'C' => 'acn_docente',
                'D' => 'codigo_uc',
                'E' => 'acn_uc',
                'F' => 'responsavel_uc',
                'G' => 'nome_uc',
                'H' => 'curso',
                'I' => 'horas',
                'J' => 'percentagem',
            ];

            foreach ($cellIterator as $index => $cell) {
                $val = $cell->getValue();

                $lineData[$columnsMap[$index]] = $val;
            }

            array_push($data, $lineData);
        }

        /*  
            todo - adicionar maneira para o admin visualizar dados antes de submeter
            visualização em tabela? ou mais hierárquico
            em tabela talvez valores 'maus' aparecem contra outra cor,
                ou problemas aparecem numa caixa de dialogo perto da tabela
                e o admin pode editar os valores
                - nesse caso, para manter o parsing do Excel no servidor
                  vair ser preciso mais código no cliente, para lidar com as respostas
                  e voltar a mandar os novos dados?
        */

        DB::beginTransaction();
        try {
            $periodo = Periodo::where('ano', $ano)
                ->where('semestre', $semestre)
                ->first();

            if (is_null($periodo)) {
                $periodo = Periodo::create([
                    'ano' => $ano,
                    'semestre' => $semestre,
                    'data_inicial' => '2024-08-01',
                    'data_final' => '2024-09-01'
                ]);

                $periodo->save();
            }

            $faker = FakerFactory::create('pt_PT');

            foreach ($data as $d) {
                $acn_docente = ACN::where('sigla', $d['acn_docente'])->first();
                if (is_null($acn_docente)) {
                    throw new Exception('ACN do Docente: não reconhecida!');
                }

                $docente = Docente::where('numero_funcionario', $d['numero_docente'])->with('user')->first();
                if (is_null($docente)) {
                    $docente = Docente::create([
                        'numero_funcionario' => $d['numero_docente'],
                        'numero_telefone' => $faker->phoneNumber(),
                        'acn_id' => $acn_docente->id
                    ]);
                    $docente->save();
                }

                $user = $docente->user;
                if (is_null($user)) {
                    $user = User::create([
                        'nome' => $d['nome_docente'],
                        'email' => strtolower(str_replace(' ', '.', $d['nome_docente'])) . $faker->unique()->randomNumber(5, true) . '@estga.pt',
                        'password' => bcrypt('password'),
                        'admin' => false,
                    ]);
                    $user->docente()->associate($docente);
                    $user->save();
                }

                $docente->refresh();
                if ($docente->user->nome !== $d['nome_docente']) {
                    throw new Exception('Nome docente: diferenças entre nome no ficheiro e nome na base de dados!');
                }

                if ($docente->acn->sigla !== $d['acn_docente']) {
                    throw new Exception('ACN do Docente: mais do que uma ACN para o mesmo docente!');
                }

                $acn_uc = ACN::where('sigla', $d['acn_uc'])->first();
                if (is_null($acn_uc)) {
                    throw new Exception('ACN da UC: não reconhecida!');
                }

                $uc = UnidadeCurricular::where('codigo', $d['codigo_uc'])
                    ->where('periodo_id', $periodo->id)
                    ->first();

                if (is_null($uc)) {
                    $uc = UnidadeCurricular::create([
                        'codigo' => $d['codigo_uc'],
                        'nome' => $d['nome_uc'],
                        'periodo_id' => $periodo->id,
                        'acn_id' => $acn_docente->id,
                        'docente_responsavel_id' => NULL,
                        'sigla' => '',
                        'horas_semanais' => $d['horas'],
                        'ects' => '0',
                        'restricoes_submetidas' => false,
                        'sala_laboratorio' => false,
                        'exame_final_laboratorio' => false,
                        'exame_recurso_laboratorio' => false,
                        'observacoes_laboratorios' => '',
                        'software' => '',
                    ]);

                    if (!empty(trim($d['responsavel_uc']))) {
                        $uc->docente_responsavel_id = $docente->id;
                    }

                    $words = explode(" ",  $d['nome_uc']);
                    foreach ($words as $word) {
                        $initial = $word[0];
                        if (ctype_upper($initial)) {
                            $uc->sigla .= $initial;
                        }
                    }

                    $uc->save();
                }

                $uc->refresh();
                if (is_null($uc->docente_responsavel_id) && !empty(trim($d['responsavel_uc']))) {
                    $uc->docente_responsavel_id = $docente->id;
                    $uc->save();
                }

                $curso = Curso::where('sigla', $d['curso'])->first();
                if (is_null($curso)) {
                    throw new Exception('Curso da UC: sigla não reconhecida');
                }

                if (!$uc->cursos->contains($curso)) {
                    $uc->cursos()->attach($curso);
                }

                if ($uc->docentes->contains($docente)) {
                    throw new Exception('Docente e UC: este docente já estava associado à UC');
                }
                $uc->docentes()->attach($docente, ['percentagem_semanal' => $d['percentagem']]);
            }

            DB::commit();
            return response()->json(['message' => 'sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function download(Request $request)
    {
        $periodo = Periodo::orderBy('ano', 'desc')
            ->orderBy('semestre', 'desc')
            ->first();

        $filename = 'output_restricoes_' . $periodo->ano . '_' . $periodo->semestre . '.xlsx';

        try {
            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $colunas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O'];
            //Primeira Linha
            $cabecalho = [
                '1' => 'n.º Fun',           //Número funcionário
                '2' => 'nome docente',
                '3' => 'cód',               //código da UC
                '4' => 'ACN',               //ACN (uc?)
                '5' => 'R',                 //Responsável pela UC
                '6' => 'nome UC',
                '7' => 'curso',
                '8' => 'lab',               //Laboratório para sala de aula
                '9' => 'restrições',        //Impedimentos do docente
                '10' => 'software',         //software requisitado
                '11' => 'email',            //email docente
                '12' => 'telefone',         //telefone docente
                '13' => 'h',                //numero de horas da UC
                '14' => '%',                //percentagem atribuida ao docente
                '15' => 'subT',             //numero horas p/semana (subT = % * h)
            ];

            foreach ($cabecalho as $index => $value) {
                $sheet->setCellValue($colunas[$index - 1] . '' . (1), $value);
            }

            $rowIndex = 2;

            foreach (Docente::all() as $docente) {
                foreach ($docente->unidadesCurriculares()->where('periodo_id', $periodo->id)->get() as $uc) {
                    $row = [
                        'num_func' => $docente->numero_funcionario,
                        'nome_docente' => $docente->user->nome,
                        'codigo_uc' => $uc->codigo,
                        'acn_uc' => $uc->acn->sigla,
                        'responsavel' => ($uc->docenteResponsavel && $uc->docenteResponsavel->id == $docente->id) ? 'X' : ' ',
                        'nome_uc' => $uc->nome,
                        'cursos' => implode(',', $uc->cursos()->pluck('sigla')->toArray()),
                        'sala_laboratorio' => $uc->sala_laboratorio,
                        'impedimentos' => $docente->impedimentos()->where('periodo_id', $periodo->id)->exists() ?
                            $docente->impedimentos()->where('periodo_id', $periodo->id)->first()->impedimentos :
                            '-',
                        'software' => $uc->software,
                        'email_docente' => $docente->user->email,
                        'telefone_docente' => $docente->numero_telefone,
                        'horas_semanais_uc' => $uc->horas_semanais,
                        'percentagem_docente_uc' => $uc->pivot->percentagem_semanal,
                        'subT' => $uc->pivot->percentagem_semanal * $uc->horas_semanais
                    ];

                    $colIndex = 0;
                    foreach ($row as $cell) {
                        $sheet->setCellValue($colunas[$colIndex++] . '' . $rowIndex, $cell);
                    }
                    $rowIndex++;
                }
            }

            $writer = new Xlsx($spreadsheet, 'Xlsx');
            $writer->setPreCalculateFormulas(false);

            return response($writer->save('php://output'))
                ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (Exception $e) {
            return response()->json(['message' => 'erro']);
        }

        return response()->json(['message' => $periodo->ano . ' | ' . $periodo->semestre]);
    }
}
