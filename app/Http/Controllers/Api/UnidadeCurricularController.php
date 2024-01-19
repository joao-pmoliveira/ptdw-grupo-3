<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestricoesRequest;
use App\Http\Requests\UnidadeCurricularRequest;
use App\Mail\emailMudancaRestricoes;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\UnidadeCurricular;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class UnidadeCurricularController extends Controller
{
    public function index()
    {
        try {
            $ucs = UnidadeCurricular::all();
            return response()->json($ucs, 200);
        } catch (QueryException $e) {
            return response()->json("Database error: " . $e->getMessage(), 500);
        }
    }

    public function show(UnidadeCurricular $uc)
    {
        try {
            return response()->json($uc, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json("Unidade Curricular não encontrada", 404);
        }
    }

    public function getByAnoSemestre($ano, $semestre)
    {
        $periodo = Periodo::where('ano', $ano)
            ->where('semestre', $semestre)
            ->first();

        if (!$periodo) {
            return response()->json(['error' => 'Sem registos para ano: ' . $ano . ', semestre' . $semestre], 404);
        }

        $dataType = getenv('DB_CONNECTION') === 'mysql' ? 'UNSIGNED' : 'INTEGER';
        $ucs = UnidadeCurricular::where('periodo_id', $periodo->id)
            ->with('docenteResponsavel.user')
            ->with('docentes.user')
            ->with('cursos')
            ->orderByRaw('CAST(codigo as ' . $dataType . ') asc')
            ->get();

        $ucs = $ucs->map(function ($uc) {
            $uc['link'] = route('ucs.uc.view', ['uc' => $uc->id]);
            return $uc;
        });

        return response()->json($ucs);
    }

    public function store(Request $request)
    {
        try {
            $this->authorize('admin-access');

            $rules = [
                'codigo' => ['required', 'integer', 'min:1'],
                'nome' => ['required', 'string'],
                'horas' => ['nullable', 'integer', 'min:1'],
                'ects' => ['nullable', 'integer', 'min:0'],
                'acn' => ['required', 'integer', 'exists:acns,id'],
                'docente_responsavel_id' => ['nullable', 'integer', 'exists:docentes,id'],
                'docentes_id' => ['array'],
            ];

            $messages = [
                'codigo.required' => 'Preencha o código da UC!',
                'codigo.integer' => 'Código da UC tem de ser número inteiro!',
                'codigo.min' => 'Código da UC tem de ser superior a 1!',
                'nome.required' => 'Preencha o nome da UC!',
                'nome.string' => 'Nome da UC inválido!',
                'horas.integer' => 'Horas semanais têm de ser número inteiro!',
                'horas.min' => 'Horas semanais têm de ser superiores a 1!',
                'ects.integer' => 'ECTs têm de ser número inteiro!',
                'ects.min' => 'ECTs têm de ser superiores a 0!',
                'acn.required' => 'Seleciona a Área Científica Nuclear da UC!',
                'acn.integer' => 'Área Científica Nuclear selecionada inválida!',
                'acn.exists' => 'Área Científica Nuclear selecionada inválida!',
                'docente_responsavel_id.integer' => 'Docente responsável selecionado inválido!',
                'docente_responsavel_id.exists' => 'Docente responsável selecionado inválido!',
                'docentes_id.array' => 'Erro de formato na seleção de docentes!',
            ];

            $validatedData = Validator::make($request->all(), $rules, $messages)->validate();

            DB::beginTransaction();

            $periodo = Periodo::orderBy('ano', 'desc')
                ->orderBy('semestre', 'desc')
                ->first();

            if (is_null($periodo)) {
                throw new Exception('Não foi possível encontrar um período (ano-semestre) disponível para a UC!');
            }

            $codigo = $validatedData['codigo'];
            $nome = $validatedData['nome'];
            $horas = $validatedData['horas'];
            $ects = $validatedData['ects'];
            $acn = $validatedData['acn'];
            $docenteResponsavelId = $validatedData['docente_responsavel_id'];
            $docentesId = $validatedData['docentes_id'] ?? [];


            if (UnidadeCurricular::where('codigo', $codigo)->exists()) {
                if (UnidadeCurricular::where('codigo', $codigo)->where('nome', $nome)->where('periodo_id', $periodo->id)->exists()) {
                    throw new Exception('Código e Nome já estão atribuídos para uma UC, no ano ' . $periodo->ano . ' e semestre ' . $periodo->semestre);
                } else if (UnidadeCurricular::where('codigo', $codigo)->where('nome', $nome)->doesntExist()) {
                    throw new Exception('Código e Nome não coincidem com dados na base de dados.');
                }
            }

            $uc = UnidadeCurricular::create([
                'codigo' => $codigo,
                'nome' => $nome,
                'periodo_id' => $periodo->id,
                'acn_id' => $acn,
                'docente_responsavel_id' => $docenteResponsavelId,
                'horas_semanais' => $horas,
                'ects' => $ects,
                'restricoes_submetidas' => false,
                'sala_laboratorio' => false,
                'exame_final_laboratorio' => false,
                'exame_recurso_laboratorio' => false,
                'observacoes_laboratorios' => '',
                'software' => '',
            ]);

            $uc->save();

            $docenteResponsavel = Docente::find($docenteResponsavelId) ?? null;

            if ($docenteResponsavel) {
                //todo @joao: calcular % semanal do docente
                $uc->docentes()->attach($docenteResponsavel, ['percentagem_semanal' => 1]);
                $uc->refresh();
            }

            foreach ($docentesId as $docenteId) {
                if (is_null($docenteId)) {
                    continue;
                }

                $docente = Docente::findOrFail($docenteId);
                // todo @joao: calcular %semanal
                $uc->docentes()->attach($docente, ['percentagem_semanal' => 1]);
            }
            $uc->refresh();

            DB::commit();

            // todo @joao: enviar para os restantes docentes tbm
            if ($docenteResponsavel) {
                $hoje = now();
                $data_inicial = Carbon::createFromFormat('Y-m-d', $uc->periodo->data_inicial);
                $data_final = Carbon::createFromFormat('Y-m-d', $uc->periodo->data_final);

                if ($hoje->betweenIncluded($data_inicial, $data_final)) {
                    // todo @joao: rever processo de mandar email, parece que dá para simplificar bastante
                    Mail::to($docenteResponsavel->user->email)->send(new emailMudancaRestricoes($docenteResponsavel, $uc->periodo, $uc, $uc->periodo->data_final));
                }
            }


            // todo @joao: mais informação? inserir nome da UC e/ou periodo
            return redirect(route('admin.gerir.view'))->with('sucesso', 'Unidade Curricular adicionada com sucesso!');
        } catch (AuthorizationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', 'Sem permissões para adicionar nova UC!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', $e->getMessage());
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', 'Erro ao enviar formulário!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->authorize('admin-access');

            $uc = UnidadeCurricular::findOrFail($id);

            $rules = [
                'codigo' => ['required', 'integer', 'min:1'],
                'nome' => ['required', 'string'],
                'horas' => ['nullable', 'integer', 'min:1'],
                'ects' => ['nullable', 'integer', 'min:1'],
                'acn' => ['required', 'integer', 'exists:acns,id'],
                'docente_responsavel_id' => ['nullable', 'integer', 'exists:docentes,id'],
                'docentes_id' => ['array'],
            ];
            $messages = [
                'codigo.required' => 'Preencha o código da UC!',
                'codigo.integer' => 'Código tem que ser número inteiro!',
                'codigo.min' => 'Código tem que ser superior a 1!',
                'nome.required' => 'Preencha o nome da UC!',
                'nome.string' => 'Introduza um nome válido!',
                'horas.integer' => 'Horas semanais têm que ser um número inteiro',
                'horas.min' => 'Horas semanais têm que ser superiores a 1!',
                'ects.integer' => 'ECTs têm que ser número inteiro!',
                'ects.min' => 'ECTS têm que ser superiores a 1!',
                'acn.required' => 'Selecione a Área Científica Nuclear da UC!',
                'acn.integer' => 'Área Científica Nuclear inválida!',
                'acn.exists' => 'Área Científica Nuclear inválida!',
                'docente_responsavel_id.integer' => 'Docente Responsável inválido!',
                'docente_responsavel_id.exists' => 'Docente Responsável inválido!',
            ];

            $validatedData = Validator::make($request->all(), $rules, $messages)->validate();

            $antigoDocResponsavel = $uc->docenteResponsavel ?? null;
            $docentesId = $validatedData['docentes_id'];

            DB::beginTransaction();

            $codigo = $validatedData['codigo'];
            $nome = $validatedData['nome'];
            $periodo = $uc->periodo;


            $ucsComMesmoCodigo = UnidadeCurricular::where('codigo', $codigo)->get();
            if ($ucsComMesmoCodigo->isNotEmpty()) {
                $ucsComMesmoNome = $ucsComMesmoCodigo->where('nome', $nome);
                if ($ucsComMesmoNome->isNotEmpty()) {
                    $ucsComMesmoPeriodo = $ucsComMesmoNome->where('periodo_id', $uc->periodo->id)->where('id', '<>', $uc->id);
                    if ($ucsComMesmoPeriodo->isNotEmpty()) {
                        throw new Exception('Já existe UC com o mesmo Código e Nome!');
                    }
                } else {
                    throw new Exception('Código e Nome não disponíveis!');
                }
            }

            $uc->update([
                'codigo' => $validatedData['codigo'],
                'nome' => $validatedData['nome'],
                'acn_id' => $validatedData['acn'],
                'docente_responsavel_id' => $validatedData['docente_responsavel_id'],
                'horas_semanais' => $validatedData['horas'],
                'ects' => $validatedData['ects'],
            ]);

            $uc->docentes()->detach();

            $atualDocenteResponsavel = Docente::find($validatedData['docente_responsavel_id']) ?? null;
            if ($atualDocenteResponsavel) {
                //todo @joao: definir percentagem semanal
                $uc->docentes()->attach($atualDocenteResponsavel, ['percentagem_semanal' => 1]);
            }

            foreach ($docentesId as $docenteId) {
                if (is_null($docenteId)) {
                    continue;
                }

                $docente = Docente::findOrFail($docenteId);
                //todo @joao: definir percentagem semanal
                $uc->docentes()->attach($docente, ['percentagem_semanal' => 1]);
            }

            DB::commit();

            //* Enviar email se:
            //  - não havia docente responsavel e agora há
            //  - havia e já não há
            //  - havia e também há mas é diferente
            if ((!$antigoDocResponsavel && $atualDocenteResponsavel) ||
                ($antigoDocResponsavel && !$atualDocenteResponsavel) ||
                ($antigoDocResponsavel && $atualDocenteResponsavel && $antigoDocResponsavel->id !== $atualDocenteResponsavel->id)
            ) {
                $hoje = now();
                $data_inicial = Carbon::createFromFormat('Y-m-d', $uc->periodo->data_inicial);
                $data_final = Carbon::createFromFormat('Y-m-d', $uc->periodo->data_final);

                if ($hoje->betweenIncluded($data_inicial, $data_final)) {
                    //todo @joao: enviar aviso para os outros docentes tbm
                    //tanto aqueles que foram adicionar como 'docentes restante'
                    //tanto aqueles que foram retirados da UC, seja o antigo responsavel 
                    // seja os antigos 'restantes'
                    Mail::to($atualDocenteResponsavel->user->email)->send(new emailMudancaRestricoes($atualDocenteResponsavel, $uc->periodo, $uc, $uc->periodo->data_final));
                }
            }

            return redirect(route('admin.gerir.view'))->with('sucesso', 'Unidade Curricular editada com sucesso!');
        } catch (AuthorizationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', 'Sem permissões para editar esta Unidade Curricular!');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', 'Erro ao submeter edições');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->authorize('admin-access');

            $uc = UnidadeCurricular::findOrFail($id);

            DB::beginTransaction();

            $nome = $uc->nome;

            $uc->docentes()->detach();
            $uc->cursos()->detach();
            $uc->delete();

            DB::commit();
            return redirect(route('admin.gerir.view'))->with('sucesso', $nome . ' : UC eliminada com sucesso!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', 'Sem permissões para eliminar UC!');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', 'Erro ao tentar eliminar UC!');
        }
    }

    public function updateRestricao(Request $request, $id)
    {
        try {
            $uc = UnidadeCurricular::findOrFail($id);

            $this->authorize('updateRestricoes', $uc);

            $salaLaboratorio = is_null($request->input('sala_laboratorio')) ? false : true;
            $exameFinalLaboratorio = is_null($request->input('exame_final_laboratorio')) ? false : true;
            $exameRecursoLaboratorio = is_null($request->input('exame_recurso_laboratorio')) ? false : true;
            $observacoes = $request->input('observacoes') ?? '';
            $software = $request->input('software') ?? '';

            $uc->update([
                'sala_laboratorio' => $salaLaboratorio,
                'exame_final_laboratorio' => $exameFinalLaboratorio,
                'exame_recurso_laboratorio' => $exameRecursoLaboratorio,
                'software' => $software,
                'observacoes_laboratorios' => $observacoes,
                'restricoes_submetidas' => true,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('alerta', 'Erro ao enviar formulário!');
        } catch (AuthorizationException $e) {
            return redirect()->back()->with('alerta', 'Não tem permissões para submeter este formulário!');
        }

        return redirect()->back()->with('sucesso', 'Restrições submetidas com sucesso!');
    }
}
