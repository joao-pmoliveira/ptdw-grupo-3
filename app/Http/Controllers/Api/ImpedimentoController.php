<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImpedimentoRequest;
use App\Models\Impedimento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ImpedimentoController extends Controller
{
    public function index() {
        try {
            $impedimentos = Impedimento::all();
            return response()->json($impedimentos, 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: '.$e->getMessage()], 500);
        }
    }

    public function show(Impedimento $impedimento) {
        try {
            return response()->json($impedimento, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Impedimento não encontrado'], 404);
        }
    }

    public function store(ImpedimentoRequest $impedimentoRequest) {}

    public function update(ImpedimentoRequest $impedimentoRequest, Impedimento $impedimento) {}

    public function delete(Impedimento $impedimento) {}
}
