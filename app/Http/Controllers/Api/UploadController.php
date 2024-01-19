<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ACN;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\UnidadeCurricular;
use App\Models\User;
use Database\Factories\PeriodoFactory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Faker\Factory as FakerFactory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        try {

            $this->authorize('admin-access');


            $rules = [
                'uc-data-file' => ['required', 'mimes:xlsx', 'max:10240'],
                'file-start-year' => ['required', 'integer', 'gte:2023'],
                'file-semestre' => ['required', 'integer', 'in:1,2'],
            ];

            $messages = [
                'uc-data-file.required' => 'Introduza um ficheiro Excel (xlsx)!',
                'uc-data-file.mimes' => 'Ficheiro introduzido num formato inálido. Insira um ficheiro xlsx!',
                'uc-data-file.max' => 'Ficheiro introduzido demasiado grande!',
                'file-start-year.required' => 'Preencha o ano correspondente ao ficheiro!',
                'file-start-year.integer' => 'Ano introduzido inválido!',
                'file-start-year.gte' => 'Ano introduzido inválido!',
                'file-semestre.required' => 'Preencha o semestre correspondente ao ficheiro!',
                'file-semestre.integer' => 'Semestre introduzido inválido!',
                'file-semestre.in' => 'Semestre introduzido inválido!',
            ];

            $validatedData = Validator::make($request->all(), $rules, $messages)->validate();

            $ano = $validatedData['file-start-year'];
            $semestre = $validatedData['file-semestre'];
            $file = $validatedData['uc-data-file'];

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

                    if (array_key_exists($index, $columnsMap)) {
                        $lineData[$columnsMap[$index]] = $val;
                    }
                }

                array_push($data, $lineData);
            }

            // todo - adicionar maneira para o admin visualizar os dados a importar antes de submter (e erros)
            // visualização em tabela ou mais hierárquico
            // em tabela: talvez valores 'maus' aparecem com outra cor
            //      ou problemas aparecem numa caixa de diálogo perto da tabela
            //      e o admin pode editar os valores diretamente

            DB::beginTransaction();
            $periodo = Periodo::where('ano', $ano)
                ->where('semestre', $semestre)
                ->first();

            if (is_null($periodo)) {

                $datas = PeriodoFactory::gerarDatasPeriodo($ano, $semestre);

                $periodo = Periodo::create([
                    'ano' => $ano,
                    'semestre' => $semestre,
                    'data_inicial' => $datas['data_inicial'],
                    'data_final' => $datas['data_final'],
                ]);
                $periodo->save();
            }

            $faker = FakerFactory::create('pt_PT');

            foreach ($data as $d) {
                //Assume que se o ACN não está na BD, é um ACN errado
                $acn_docente = ACN::where('sigla', $d['acn_docente'])->first();
                dd($acn_docente);
                if (is_null($acn_docente)) {
                    //todo @joao: adicionar o nome ou linha em que acontece
                    throw new Exception('Área Científica do Docente: não reconhecida!');
                }

                // Assume que se o docente não está na BD, este é um docente novo

                $docente = Docente::all()->filter(function ($docente) use ($d) {
                    return $docente->user->numero_funcionario == $d['numero_docente'];
                })->first();

                if (is_null($docente)) {
                    $docente = Docente::create([
                        'acn_id' => $acn_docente->id
                    ]);
                    $docente->save();
                }

                $user = $docente->user;
                if (is_null($user)) {
                    $user = User::create([
                        'nome' => $d['nome_docente'],
                        //todo @joao: remover geração automática do email
                        //'email' => strtolower(str_replace(' ', '.', Str::ascii($d['nome_docente']))) . $faker->unique()->randomNumber(5, true) . '@estga.pt',
                        'email' => null,
                        'password' => bcrypt('password'),
                        'admin' => false,
                        'numero_funcionario' => $d['numero_docente'],
                        'numero_telefone' => null,
                    ]);
                    $user->docente()->associate($docente);
                    $user->save();
                }

                $docente->refresh();
                if ($docente->user->nome !== $d['nome_docente']) {
                    //todo @joao: adicionar mais informação onde o erro ocorre
                    throw new Exception('Nome docente: diferenças entre nome no ficheiro e nome na base de dados!');
                }
                if ($docente->acn->sigla !== $d['acn_docente']) {
                    //todo @joao: adicionar mais informação onde o erro ocorre
                    throw new Exception('ACN do Docente: mais do que uma ACN para o mesmo docente!');
                }
                $acn_uc = ACN::where('sigla', $d['acn_uc'])->first();
                if (is_null($acn_uc)) {
                    //todo @joao: adicionar mais informação onde o erro ocorre
                    throw new Exception('ACN da UC: não reconhecida!');
                }

                //Compara apenas o período indicado pelo o ficheiro
                //evitar conflitos com UCs com o mesmo código mas de diferentes períodos
                $uc = UnidadeCurricular::where('codigo', $d['codigo_uc'])
                    ->where('periodo_id', $periodo->id)
                    ->first();

                //Assume que se a UC não está na BD é uma UC nova
                if (is_null($uc)) {
                    $uc = UnidadeCurricular::create([
                        'codigo' => $d['codigo_uc'],
                        'nome' => $d['nome_uc'],
                        'periodo_id' => $periodo->id,
                        'acn_id' => $acn_docente->id,
                        'docente_responsavel_id' => NULL,
                        'horas_semanais' => $d['horas'],
                        'ects' => '6',
                        'restricoes_submetidas' => false,
                        'sala_laboratorio' => false,
                        'exame_final_laboratorio' => false,
                        'exame_recurso_laboratorio' => false,
                        'observacoes_laboratorios' => '',
                        'software' => '',
                    ]);

                    //todo @joao: não está a verificar se a UC já tem responsavel
                    //caso haja erro no ficheiro com dois docentes responsaveis para a UC
                    //o que 'aparecer' depois é o docente responsável
                    if (!empty(trim($d['responsavel_uc']))) {
                        $uc->docente_responsavel_id = $docente->id;
                    }

                    $uc->save();
                }

                $uc->refresh();
                if (is_null($uc->docente_responsavel_id) && !empty(trim($d['responsavel_uc']))) {
                    $uc->docente_responsavel_id = $docente->id;
                    $uc->save();
                }

                //Assume que se o Curso não está na BD é porque é erro
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
            return redirect()->back()->with('sucesso', 'Dados importados com sucesso!');
        } catch (AuthorizationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', 'Sem permissões para importar dados!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', $e->getMessage());
        }
    }

    public function download($periodo_id)
    {
        try{
        $periodo = Periodo::find($periodo_id);

        $filename = 'output_restricoes_' . $periodo->ano . '_' . $periodo->semestre . '.xlsx';


            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Por Docente');

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

            //First Worksheet - Por Docente
            $finalData = [];
            foreach (Docente::all() as $docente) {
                foreach ($docente->unidadesCurriculares()->where('periodo_id', $periodo->id)->get() as $uc) {
                    $row = [
                        'num_func' => $docente->user->numero_funcionario,
                        'nome_docente' => $docente->user->nome,
                        'codigo_uc' => $uc->codigo,
                        'acn_uc' => $uc->acn->sigla,
                        'responsavel' => ($uc->docenteResponsavel && $uc->docenteResponsavel->id == $docente->id) ? 'X' : ' ',
                        'nome_uc' => $uc->nome,
                        'cursos' => implode(',', $uc->cursos()->pluck('sigla')->toArray()),
                        'sala_laboratorio' => $uc->sala_laboratorio ? 'X' : ' ',
                        'impedimentos' => $docente->impedimentos()->where('periodo_id', $periodo->id)->exists() ?
                            $docente->impedimentos()->where('periodo_id', $periodo->id)->first()->impedimentos :
                            '-',
                        'software' => $uc->software,
                        'email_docente' => $docente->user->email,
                        'telefone_docente' => $docente->user->numero_telefone,
                        'horas_semanais_uc' => $uc->horas_semanais,
                        'percentagem_docente_uc' => $uc->pivot->percentagem_semanal,
                        'subT' => $uc->pivot->percentagem_semanal * $uc->horas_semanais
                    ];

                    array_push($finalData, $row);
                }
            }

            usort($finalData, function ($a, $b) {
                return $a['num_func'] - $b['num_func'];
            });

            foreach ($finalData as $row) {
                $colIndex = 0;
                foreach ($row as $key => $cell) {
                    if ($key === 'telefone_docente') {
                        $sheet->setCellValueExplicit($colunas[$colIndex++] . '' . $rowIndex, $cell, DataType::TYPE_STRING);
                    } else {
                        $sheet->setCellValue($colunas[$colIndex++] . '' . $rowIndex, $cell);
                    }
                }
                $rowIndex++;
            }

            //Second Worksheet - Por UC
            $ucSheet = new Worksheet($spreadsheet, 'Por UC');
            $spreadsheet->addSheet($ucSheet);

            $spreadsheet->setActiveSheetIndex(1);
            $sheet = $spreadsheet->getActiveSheet();

            usort($finalData, function ($a, $b) {
                return $a['codigo_uc'] - $b['codigo_uc'];
            });

            foreach ($cabecalho as $index => $value) {
                $sheet->setCellValue($colunas[$index - 1] . '' . (1), $value);
            }
            $rowIndex = 2;

            foreach ($finalData as $row) {
                $colIndex = 0;
                foreach ($row as $key => $cell) {
                    if ($key === 'telefone_docente') {
                        $sheet->setCellValueExplicit($colunas[$colIndex++] . '' . $rowIndex, $cell, DataType::TYPE_STRING);
                    } else {
                        $sheet->setCellValue($colunas[$colIndex++] . '' . $rowIndex, $cell);
                    }
                }
                $rowIndex++;
            }

            //Third Worksheet - Por Curso
            $cursoSheet = new Worksheet($spreadsheet, 'Por Curso');
            $spreadsheet->addSheet($cursoSheet);

            $spreadsheet->setActiveSheetIndex(2);
            $sheet = $spreadsheet->getActiveSheet();

            usort($finalData, function ($a, $b) {
                $cursoA = $a['curso'] ?? '';
                $cursoB = $b['curso'] ?? '';

                if (empty($cursoA) && empty($cursoB)) {
                    return 0;
                } elseif (empty($cursoA)) {
                    return -1;
                } elseif (empty($cursoB)) {
                    return 1;
                }

                return strcasecmp($cursoA, $cursoB);
            });


            foreach ($cabecalho as $index => $value) {
                $sheet->setCellValue($colunas[$index - 1] . '' . (1), $value);
            }
            $rowIndex = 2;

            foreach ($finalData as $row) {
                $colIndex = 0;
                foreach ($row as $key => $cell) {
                    if ($key === 'telefone_docente') {
                        $sheet->setCellValueExplicit($colunas[$colIndex++] . '' . $rowIndex, $cell, DataType::TYPE_STRING);
                    } else {
                        $sheet->setCellValue($colunas[$colIndex++] . '' . $rowIndex, $cell);
                    }
                }
                $rowIndex++;
            }

            $writer = new Xlsx($spreadsheet, 'Xlsx');
            $writer->setPreCalculateFormulas(false);

            Session::flash('sucesso', 'Ficheiro descarregado com sucesso');

            return response($writer->save('php://output'))
                ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (Exception $e) {
            Session::flash('alerta', 'Erro ao descarregar ficheiro!');
            return response()->json(['message' => 'erro']);
        }
    }
}
