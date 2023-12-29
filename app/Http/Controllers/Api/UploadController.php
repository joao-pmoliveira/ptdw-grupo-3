<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ACN;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\UnidadeCurricular;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Faker\Factory as FakerFactory;

use function PHPSTORM_META\map;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'uc-data-file' => 'required|mimes:xlsx|max:10240'
        ]);

        $file = $request->file('uc-data-file');

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

            $lineData = [
                'numero_docente' => '',
                'nome_docente' => '',
                'acn_docente' => '',
                'codigo_uc' => '',
                'acn_uc' => '',
                'responsavel_uc' => '',
                'nome_uc' => '',
                'curso' => '',
                'horas' => '',
                'percentagem' => '',
            ];

            foreach ($cellIterator as $index => $cell) {
                $val = $cell->getValue();

                match ($index) {
                    'A' => $lineData['numero_docente'] = $val,
                    'B' => $lineData['nome_docente'] = $val,
                    'C' => $lineData['acn_docente'] = $val,
                    'D' => $lineData['codigo_uc'] = $val,
                    'E' => $lineData['acn_uc'] = $val,
                    'F' => $lineData['responsavel_uc'] = $val,
                    'G' => $lineData['nome_uc'] = $val,
                    'H' => $lineData['curso'] = $val,
                    'I' => $lineData['horas'] = $val,
                    'J' => $lineData['percentagem'] = $val,
                };
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
            // todo - como melhor detetar a que ano/semestre o ficheiro se refere
            // para efetiso de teste, adicionar ao primeiro semestre de 2024/2025

            $periodo = Periodo::where('ano', 2024)
                ->where('semestre', 1)
                ->first();

            if ($periodo == NULL) {
                $periodo = Periodo::create([
                    'ano' => 2024,
                    'semestre' => 1,
                    'data_inicial' => '2024-08-01',
                    'data_final' => '2024-09-01'
                ]);

                $periodo->save();
            }

            $faker = FakerFactory::create('pt_PT');

            foreach ($data as $d) {
                $acn_docente = ACN::where('sigla', $d['acn_docente'])->first();
                if ($acn_docente == NULL) {
                    // todo - como lidar?
                    // se todas as ACNs possíveis forem introduzidas manualmente no sistema? não aceitar erros
                    // se não ? "erro" pode ser 'nova' ACN que ainda não está no sistema
                    // para efeitos de teste: assume que todos os ACNs possíveis já estão no sistema

                    throw new Exception('ACN do Docente: não reconhecida!');
                }

                $docente = Docente::where('numero_funcionario', $d['numero_docente'])->first();
                if ($docente == NULL) {
                    $docente = Docente::create([
                        'nome' => $d['nome_docente'],
                        'numero_funcionario' => $d['numero_docente'],
                        'email' => strtolower(str_replace(' ', '.', $d['nome_docente'])) . $faker->unique()->randomNumber(5, true) . "@estga.pt",
                        'numero_telefone' => $faker->phoneNumber()
                    ]);
                    $docente->acn()->associate($acn_docente);
                    $docente->save();

                    // todo - email de docente:
                    // para efeitos de test: email placeholder, gerado automaticamente
                    // - email real introduzido pelos admins?
                    // - associado quando o docente faz o primeiro login com email + numero de funcionario?
                }

                if ($docente->nome != $d['nome_docente']) {
                    // todo - como lidar?
                    // nome do docente que vem no ficheiro não é igual ao nome do docente
                    // na base de dados
                    // provavelmente erro ao colocar numero no ficheiro excel
                    // OU
                    // em vez de colocar nome completo, colocar primeiro e último?

                    throw new Exception('Nome docente: diferente entre ficheiro e base de dados!');
                }

                if ($docente->acn->sigla != $d['acn_docente']) {
                    // todo - como lidar?
                    // no ficheiro a ACN atribuída ao docente é diferente à ACN que está atribuída
                    // ao docente na base de dados.
                    // Docentes apenas estão associados a uma ACN;

                    throw new Exception('ACN do Docente: mais do que uma ACN para o mesmo docente!');
                }

                $acn_uc = ACN::where('sigla', $d['acn_uc'])->first();
                if ($acn_uc == NULL) {
                    // igual ao caso da acn do docente

                    throw new Exception('ACN da UC: não reconhecida!');
                }

                $uc = UnidadeCurricular::where('codigo', $d['codigo_uc'])
                    ->where('periodo_id', $periodo->id)
                    ->first();
                if ($uc == NULL) {


                    $uc = UnidadeCurricular::create([
                        'codigo' => $d['codigo_uc'],
                        'nome' => $d['nome_uc'],
                        'periodo_id' => $periodo->id,
                        'acn_id' => $acn_docente->id,
                        // todo - mudar campo para nullable, para ao criar colocar valores temporarios
                        // caso o primeiro docente associado a esta UC não seja o responsavel
                        'docente_responsavel_id' => (!empty(trim($d['responsavel_uc']))) ? $docente->id : 1,
                        'sigla' => '',
                        'horas_semanais' => $d['horas'],
                        'laboratorio' => false,
                        'software' => '',
                        'ects' => '0',
                        'sala_avaliacao' => false,
                    ]);

                    $words = explode(" ",  $d['nome_uc']);
                    foreach ($words as $word) {
                        $initial = $word[0];
                        if (ctype_upper($initial)) {
                            $uc->sigla .= $initial;
                        }
                    }

                    $uc->save();
                }

                $curso = Curso::where('sigla', $d['curso'])->first();
                if ($curso == NULL) {
                    // todo - como lidar
                    // mesmo caso com as ACNs
                    // em principio não se irá ter todos os cursos já no sistema
                    // por isso adicionar um novo quando isto acontece
                    //  - nome
                    //  - sigla

                    throw new Exception('Curso da UC: sigla não reconhecida');
                }

                if (!$uc->cursos->contains($curso)) {
                    $uc->cursos()->attach($curso);
                }

                if ($uc->docentes->contains($docente)) {
                    // todo - como lidar
                    // se a unidade curricular já tem este docente associado é porque:
                    // - houve um erro no ficheiro input, em que o docente tem duas linhas para a mesma UC
                    // - o admin tentou enviar o ficheiro mais do que uma vez
                    // - os dados do ficheiros são de um periodo que já existe no sistema
                    throw new Exception('Docente e UC: este docente já estava associado à UC');
                }

                $uc->docentes()->attach($docente, ['percentagem_semanal' => $d['percentagem']]);
            }

            DB::commit();
            return redirect(route('inicio.view'), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('admin.gerir.view'));
        }
    }
}
