<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImpedimentoRequest;
use App\Mail\emailAberturaRestricoes;
use App\Mail\emailRestricoesEmFaltaAPedidoDoAdmin;
use App\Models\Docente;
use App\Models\Impedimento;
use App\Models\Periodo;
use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ImpedimentoController extends Controller
{
    public function index()
    {
        try {
            $impedimentos = Impedimento::all();
            return response()->json($impedimentos, 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function show(Impedimento $impedimento)
    {
        try {
            return response()->json($impedimento, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Impedimento não encontrado'], 404);
        }
    }

    public function store(ImpedimentoRequest $impedimentoRequest)
    {
    }

    public function update(Request $request, $id)
    {
        try {
            $impedimento = Impedimento::findOrFail($id);

            $this->authorize('updateImpedimento', $impedimento);

            $num_blocos_livres = count(array_filter([
                $request->input('segunda_manha'),
                $request->input('segunda_tarde'),
                $request->input('segunda_noite'),
                $request->input('terca_manha'),
                $request->input('terca_tarde'),
                $request->input('terca_noite'),
                $request->input('quarta_manha'),
                $request->input('quarta_tarde'),
                $request->input('quarta_noite'),
                $request->input('quinta_manha'),
                $request->input('quinta_tarde'),
                $request->input('quinta_noite'),
                $request->input('sexta_manha'),
                $request->input('sexta_tarde'),
                $request->input('sexta_noite'),
                $request->input('sabado_manha'),
                $request->input('sabado_tarde'),
                $request->input('sabado_noite'),
            ], function ($var) {
                return is_null($var);
            }));

            if ($num_blocos_livres < 2) {
                return redirect()->back()->with('alerta', 'Tem que manter pelo menos DOIS blocos livres!');
            }

            $max_blocos_livres = 6 * 3;
            if ($num_blocos_livres !== ($max_blocos_livres) && empty($request->input('justificacao'))) {
                return redirect()->back()->with('alerta', 'Tem que incluir justificação para impedimentos de horário!');
            }

            $map_to_string = function ($val) {
                return is_null($val) ? '0' : '1';
            };

            $segunda = implode(',', array_map($map_to_string, [
                $request->input('segunda_manha'),
                $request->input('segunda_tarde'),
                $request->input('segunda_noite'),
            ]));
            $terca = implode(',', array_map($map_to_string, [
                $request->input('terca_manha'),
                $request->input('terca_tarde'),
                $request->input('terca_noite'),
            ]));
            $quarta = implode(',', array_map($map_to_string, [
                $request->input('quarta_manha'),
                $request->input('quarta_tarde'),
                $request->input('quarta_noite'),
            ]));
            $quinta = implode(',', array_map($map_to_string, [
                $request->input('quinta_manha'),
                $request->input('quinta_tarde'),
                $request->input('quinta_noite'),
            ]));
            $sexta = implode(',', array_map($map_to_string, [
                $request->input('sexta_manha'),
                $request->input('sexta_tarde'),
                $request->input('sexta_noite'),
            ]));
            $sabado = implode(',', array_map($map_to_string, [
                $request->input('sabado_manha'),
                $request->input('sabado_tarde'),
                $request->input('sabado_noite'),
            ]));

            DB::beginTransaction();

            $impedimento->impedimentos = implode(';', [$segunda, $terca, $quarta, $quinta, $sexta, $sabado]);
            $impedimento->justificacao = $request->input('justificacao') ?? '';
            $impedimento->submetido = true;
            $impedimento->save();

            DB::commit();
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('alerta', 'Erro ao enviar formulário!');
        } catch (AuthorizationException $e) {
            return redirect()->back()->with('alerta', 'Não tem permissões para submeter formulário!');
        }

        return redirect()->back()->with('sucesso', 'Impedimentos submetidos com sucesso!');
    }

    public function delete(Impedimento $impedimento)
    {
    }

    public function gerarPorPeriodo(Request $request)
    {
        try {
            $this->authorize('admin-access');

            $rules = [
                'data_inicial' => ['required'],
                'data_final' => ['required'],
            ];

            $messages = [
                'data_inicial.required' => 'Preencha a data de aberto dos formulários',
                'data_final.required' => 'Preencha a data de fecho dos formulários',
            ];

            $validatedData = Validator::make($request->all(), $rules, $messages)->validate();

            $periodo = Periodo::orderBy('ano', 'desc')
                ->orderBy('semestre', 'desc')
                ->first();

            if (is_null($periodo)) {
                return redirect()->back()->with('alerta', 'Erro ao gerar formulários para o ano e semestre indicado!');
            }

            DB::beginTransaction();

            $periodo->update([
                'data_inicial' => $validatedData['data_inicial'],
                'data_final' => $validatedData['data_final'],
            ]);

            $docentes = Docente::all();

            foreach ($docentes as $docente) {
                $semUCsAssociadas = $docente->unidadesCurriculares()->where('periodo_id', $periodo->id)->doesntExist();
                if ($semUCsAssociadas) {
                    continue;
                }
                $comImpedimentos = $docente->impedimentos()->where('periodo_id', $periodo->id)->exists();
                if ($comImpedimentos) {
                    continue;
                }

                $impedimento = Impedimento::create([
                    'periodo_id' => $periodo->id,
                    'docente_id' => $docente->id,
                    'impedimentos' => '0,0,0;0,0,0;0,0,0;0,0,0;0,0,0;0,0,0;',
                    'justificacao' => '',
                    'submetido' => false,
                ]);
                $impedimento->save();
            }

            DB::commit();

            // todo @joao: passar para dentro do ciclo anterior
            foreach ($docentes as $docente) {
                $filteredUcsResp = $docente->ucsResponsavel()->where('periodo', $periodo)->get();
                $filteredUcs = $docente->unidadesCurriculares()->where('periodo', $periodo)->get();
                if(empty($docente->user->email)){
                    continue;
                }
                Mail::to($docente->user->email)->send(new emailAberturaRestricoes($docente, $periodo, $filteredUcsResp, $filteredUcs, $validatedData['data_final'], $validatedData['data_inicial']));
            }
            return redirect()->back()->with('sucesso', 'Formulários gerados com sucesso!');
        } catch (AuthorizationException $e) {
            return redirect()->back()->with('alerta', 'Sem permissões para gerar formulários!');
        } catch (ValidationException $e) {
            return redirect()->back()->with('alerta', $e->validator->errors()->all());
        }
    }

    public function mailMissingForms(Request $request)
    {
        try {
            $impedimentoIds = $request->input('impedimento_selecionados');
            foreach ($impedimentoIds as $impedimentoId) {
                $impedimento = Impedimento::find($impedimentoId);
                $periodo = $impedimento->periodo;
                $filteredUcsResp = $impedimento->docente->ucsResponsavel->filter(function ($ucsResponsavel) use ($periodo) {
                    return $ucsResponsavel->periodo == $periodo;
                });
                $dataLimite = $impedimento->periodo->data_final;
                $horaEmFalta = $impedimento->submetido;
                Mail::to($impedimento->docente->user->email)->send(new emailRestricoesEmFaltaAPedidoDoAdmin($impedimento->docente, $impedimento->periodo, $filteredUcsResp, $dataLimite, $horaEmFalta));
                return redirect(route('restricoes.recolha.view'))->with('sucesso', 'Emails enviados com sucesso!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('alerta', $e->getMessage());
        }
    }
}
