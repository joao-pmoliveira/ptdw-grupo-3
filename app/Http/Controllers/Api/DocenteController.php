<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocenteRequest;
use App\Models\Docente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
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

    public function store(DocenteRequest $docenteRequest) {}

    public function update(DocenteRequest $docenteRequest, Docente $docente) {}

    public function delete(Docente $docente) {}
}
