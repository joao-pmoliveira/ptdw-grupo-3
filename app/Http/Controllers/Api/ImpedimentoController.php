<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImpedimentoRequest;
use App\Models\Impedimento;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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

    public function update(ImpedimentoRequest $impedimentoRequest, $id)
    {
        if (!$impedimentoRequest->authorize()) {
            return response()->json(['message' => 'nao autorizado'], 403);
        }

        $num_blocos_livres = count(array_filter([
            $impedimentoRequest->input('segunda_manha'),
            $impedimentoRequest->input('segunda_tarde'),
            $impedimentoRequest->input('segunda_noite'),
            $impedimentoRequest->input('terca_manha'),
            $impedimentoRequest->input('terca_tarde'),
            $impedimentoRequest->input('terca_noite'),
            $impedimentoRequest->input('quarta_manha'),
            $impedimentoRequest->input('quarta_tarde'),
            $impedimentoRequest->input('quarta_noite'),
            $impedimentoRequest->input('quinta_manha'),
            $impedimentoRequest->input('quinta_tarde'),
            $impedimentoRequest->input('quinta_noite'),
            $impedimentoRequest->input('sexta_manha'),
            $impedimentoRequest->input('sexta_tarde'),
            $impedimentoRequest->input('sexta_noite'),
            $impedimentoRequest->input('sabado_manha'),
            $impedimentoRequest->input('sabado_tarde'),
            $impedimentoRequest->input('sabado_noite'),
        ], function ($var) {
            return is_null($var);
        }));

        if ($num_blocos_livres < 2) {
            return response()->json(['message' => 'Número de blocos livres unsuficiente'], 422);
        }

        if (($num_blocos_livres != (6 * 3)) and empty($impedimentoRequest->input('justificacao'))) {
            return response()->json(['message' => 'Justificacao obrigatória'], 422);
        }

        $map_to_string = function ($val) {
            return is_null($val) ? '0' : '1';
        };

        $segunda = implode(',', array_map($map_to_string, [
            $impedimentoRequest->input('segunda_manha'),
            $impedimentoRequest->input('segunda_tarde'),
            $impedimentoRequest->input('segunda_noite'),
        ]));
        $terca = implode(',', array_map($map_to_string, [
            $impedimentoRequest->input('terca_manha'),
            $impedimentoRequest->input('terca_tarde'),
            $impedimentoRequest->input('terca_noite'),
        ]));
        $quarta = implode(',', array_map($map_to_string, [
            $impedimentoRequest->input('quarta_manha'),
            $impedimentoRequest->input('quarta_tarde'),
            $impedimentoRequest->input('quarta_noite'),
        ]));
        $quinta = implode(',', array_map($map_to_string, [
            $impedimentoRequest->input('quinta_manha'),
            $impedimentoRequest->input('quinta_tarde'),
            $impedimentoRequest->input('quinta_noite'),
        ]));
        $sexta = implode(',', array_map($map_to_string, [
            $impedimentoRequest->input('sexta_manha'),
            $impedimentoRequest->input('sexta_tarde'),
            $impedimentoRequest->input('sexta_noite'),
        ]));
        $sabado = implode(',', array_map($map_to_string, [
            $impedimentoRequest->input('sabado_manha'),
            $impedimentoRequest->input('sabado_tarde'),
            $impedimentoRequest->input('sabado_noite'),
        ]));


        try {
            DB::beginTransaction();
            $impedimento = Impedimento::find($id);
            $impedimento->impedimentos = implode(';', [$segunda, $terca, $quarta, $quinta, $sexta, $sabado]);
            $impedimento->justificacao = $impedimentoRequest->input('justificacao');
            $impedimento->submetido = true;
            $impedimento->save();
            DB::commit();

            return response()->json(['message' => 'sucesso']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function delete(Impedimento $impedimento)
    {
    }
}
