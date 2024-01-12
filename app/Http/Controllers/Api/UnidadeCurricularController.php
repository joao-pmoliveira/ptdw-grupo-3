<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestricoesRequest;
use App\Http\Requests\UnidadeCurricularRequest;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\UnidadeCurricular;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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

        $ucs = UnidadeCurricular::where('periodo_id', $periodo->id)
            ->with('docenteResponsavel.user')
            ->with('docentes.user')
            ->with('cursos')
            ->orderByRaw('CAST(codigo as INTEGER) asc')
            ->get();

        return response()->json($ucs);
    }

    public function store(UnidadeCurricularRequest $ucRequest)
    {
        if (!$ucRequest->authorize()) {
            return response()->json(['message' => 'nao autorizado'], 403);
        }

        $codigo = $ucRequest->input('codigo');
        $nome = $ucRequest->input('nome');
        $horas = $ucRequest->input('horas');
        $ects = $ucRequest->input('ects');
        $acn = $ucRequest->input('acn');
        $docenteRespId = $ucRequest->input('docente_responsavel_id');
        $docentesId = $ucRequest->input('docentes_id', []);

        try {
            DB::beginTransaction();

            //Assume que se está a adicionar a UC ao periodo mais recente
            $periodo = Periodo::orderBy('ano', 'desc')
                ->orderBy('semestre', 'desc')
                ->first();

            $uc = UnidadeCurricular::create([
                'codigo' => $codigo,
                'nome' => $nome,
                'periodo_id' => $periodo->id,
                'acn_id' => $acn,
                'docente_responsavel_id' => $docenteRespId,
                'sigla' => '',
                'horas_semanais' => $horas,
                'laboratorio' => false,
                'software' => '',
                'ects' => $ects,
                'sala_avaliacao' => false,
                'restricoes_submetidas' => false,
            ]);
            $words = explode(' ', $nome);
            foreach ($words as $word) {
                $initial = $word[0];
                if (ctype_upper($initial)) {
                    $uc->sigla .= $initial;
                }
            }
            $uc->save();

            $docenteResp = Docente::where('id', $docenteRespId)->first();
            $uc->docentes()->attach($docenteResp, ['percentagem_semanal' => 1]);
            $uc->refresh();

            foreach ($docentesId as $docenteID) {
                if (is_null($docenteID)) {
                    continue;
                }

                $docente = Docente::where('id', $docenteID)->first();
                $uc->docentes()->attach($docente, ['percentagem_semanal' => 1]);
            }
            $uc->refresh();

            DB::commit();
            return response()->json([
                'message' => 'sucesso!',
                'redirect' => route('admin.gerir.view'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function update(UnidadeCurricularRequest $ucRequest, $id)
    {
        if (!$ucRequest->authorize()) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        try {
            DB::beginTransaction();

            $uc = UnidadeCurricular::find($id);

            // Obtenha os dados atualizados do request
            $codigo = $ucRequest->input('codigo');
            $nome = $ucRequest->input('nome');
            $horas = $ucRequest->input('horas');
            $ects = $ucRequest->input('ects');
            $acn = $ucRequest->input('acn');
            $docenteRespId = $ucRequest->input('docente_responsavel_id');
            $docentesId = $ucRequest->input('docentes_id', []);

            // Atualize os campos da unidade curricular
            $uc->update([
                'codigo' => $codigo,
                'nome' => $nome,
                'acn_id' => $acn,
                'docente_responsavel_id' => $docenteRespId,
                'horas_semanais' => $horas,
                'ects' => $ects,
            ]);

            // Atualize a sigla com base no nome
            $words = explode(' ', $nome);
            $uc->sigla = '';
            foreach ($words as $word) {
                $initial = $word[0];
                if (ctype_upper($initial)) {
                    $uc->sigla .= $initial;
                }
            }
            $uc->save();

            // Atualize os docentes associados
            $uc->docentes()->detach(); // Remova todos os docentes associados atualmente

            $docenteResp = Docente::find($docenteRespId);
            $uc->docentes()->attach($docenteResp, ['percentagem_semanal' => 1]);

            foreach ($docentesId as $docenteID) {
                if (is_null($docenteID)) {
                    continue;
                }

                $docente = Docente::findOrFail($docenteID);
                $uc->docentes()->attach($docente, ['percentagem_semanal' => 1]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Sucesso!',
                'redirect' => route('admin.gerir.view'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function delete(Request $ucRequest, $ucid)
    {

        try {
            DB::beginTransaction();

            $uc = UnidadeCurricular::find($ucid);


            $uc->docentes()->detach();
            $uc->cursos()->detach();

            // Delete the UnidadeCurricular
            $uc->delete();

            DB::commit();
            return response()->json([
                'message' => 'sucesso!',
                'redirect' => route('admin.gerir.view'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function updateRestricao(RestricoesRequest $request, $id)
    {
        $uc = UnidadeCurricular::find($id);

        $laboratorio = $request->input('obligatory_labs');
        $software = $request->input('needed_software');
        $salaAvaliacao = $request->input('evaluation_labs');


        $uc->update([
            'laboratorio' => is_null($laboratorio) ? false : true,
            'software' => $software,
            'sala_avaliacao' => is_null($salaAvaliacao) ? false : true,
        ]);

        return response()->json(['message' => 'sucesso'], 200);
    }
}
