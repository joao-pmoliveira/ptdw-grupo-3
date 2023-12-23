<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnidadeCurricularRequest;
use App\Models\UnidadeCurricular;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UnidadeCurricularController extends Controller
{
    public function index() {
        try {
            $ucs = UnidadeCurricular::all();
            return response()->json($ucs, 200);
        } catch (QueryException $e) {
            return response()->json("Database error: ".$e->getMessage(), 500);
        }
    }

    public function show(UnidadeCurricular $uc) {
        try {
            return response()->json($uc, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json("Unidade Curricular não encontrada", 404);
        }
    }

    public function store(UnidadeCurricularRequest $ucRequest) {}

    public function update(UnidadeCurricularRequest $ucRequest, UnidadeCurricular $uc) {}

    public function delete(UnidadeCurricular $uc) {}
}
