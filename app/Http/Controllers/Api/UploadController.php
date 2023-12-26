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
            $periodo = Periodo::where('ano_inicial', 2023)->first();
            if ($periodo == NULL) {
                throw new Exception('Ano/Semestre mal definido');
            }

            foreach ($data as $d) {
                $acn_docente = ACN::where('sigla', $d['acn_docente'])->first();
                if ($acn_docente == NULL) {
                    // todo - como lidar?
                    // se todas as ACNs possíveis forem introduzidas manualmente no sistema? não aceitar erros
                    // se não ? "erro" pode ser 'nova' ACN que ainda não está no sistema

                    throw new Exception('ACN do Docente: não reconhecida!');
                }

                $docente = Docente::where('numero_funcionario', $d['numero_docente'])->first();
                if ($docente == NULL) {
                    // todo - como lidar?
                    // procurar só código, se não encontrar, é porque é novo docente a inserir:
                    //  - nome
                    //  - acn
                    //  - numero
                    //  - email ?
                    //      - placeholder ? 
                    //      - introduzido depois pelos admins?
                    //      - associado quando o docente tentar fazer login com email + numero
                    //          e associar nessa altura?

                    throw new Exception('Código docente: nenhum registo desse docente!');
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

                $uc = UnidadeCurricular::where('codigo', $d['codigo_uc'])->first();
                if ($uc == NULL) {
                    // Não foi encontrada uma unidade curricular com este código
                    // criar novo registo da UC
                    //  - nome
                    //  - codigo
                    //  - acn
                    //  - sigla (gerar com base no nome)
                    //  - horas_semanais
                    //  - periodo
                    //  - laboratorio (por defeito é falso)
                    //  - sala_avaliacao (por defeito é falso)
                    //  - docenteResponsavel (verificar se é esta linha)

                    throw new Exception('Código UC: não reconhecido!');
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
            }

            // enquanto não estiver o processo completo, não guardar alterações feitas
            DB::rollBack();
            return response()->json(['message' => 'sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
