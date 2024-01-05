<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DocenteViewController;
use App\Http\Requests\DocenteRequest;
use App\Models\Docente;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index() {
        try {
            $docentes = Docente::all();
            return response()->json($docentes, 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: '.$e->getMessage()], 500);
        }
    }

    public function show(Docente $docente) {
        try {
            return response()->json($docente, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Docente não encontrado'], 404);
        }
    }

    public function store(DocenteRequest $docenteRequest) {
        if (!$docenteRequest->authorize()) {
            return response()->json(['message' => 'nao autorizado'], 403);
        }

        $nome = $docenteRequest->input('nome');
        $numero = $docenteRequest->input('numero');
        $email = $docenteRequest->input('email');
        $telemovel = $docenteRequest->input('telemovel');
        $acn = $docenteRequest->input('acn');

        try{
            DB::beginTransaction();

            $docente = Docente::create([
                'nome' => $nome,
                'numero_funcionario' => $numero,
                'email' => $email,
                'numero_telefone' => $telemovel,
                'acn_id' => $acn
            ]);

            $docente->save();
            $docente->refresh();
            DB::commit();

            return response()->json([
                'message' => 'sucesso!',
                'redirect' => route('admin.gerir.view'),
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function update(DocenteRequest $docenteRequest, Docente $docente) {}

    public function delete(Docente $docente) {}
}
