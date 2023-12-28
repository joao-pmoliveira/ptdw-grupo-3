<?php

namespace App\Http\Controllers;

<<<<<<< Updated upstream
use App\Models\ACN;
use App\Models\Docente;
=======
use App\Models\Periodo;
>>>>>>> Stashed changes
use App\Models\UnidadeCurricular;
use Illuminate\Http\Request;

class UnidadeCurricularViewController extends Controller
{
    public function unidadesCurriculares() {
        // $unidadesCurriculares = UnidadeCurricular::all();

        $periodo = Periodo::where("ano", 2023)->where("semestre", 1)->first();

        $unidadesCurriculares = UnidadeCurricular::where("periodo_id", $periodo->id)->get();

        return view('unidadesCurriculares', [
            'page_title' => 'Consultar Unidades Curriculares',
            'ucs' => $unidadesCurriculares
        ]);
    }

    public function unidadeCurricular(UnidadeCurricular $uc) {
        return view('unidadeCurricular', [
            'page_title' => 'Unidade Curricular',
            'uc' => $uc
        ]);
    }

    public function editarUnidadeCurricular(UnidadeCurricular $uc) {
        $acns=ACN::all();
        $docentes=Docente::all();
        return view('editarUnidadeCurricular', [
            'page_title' => 'Unidade Curricular',
            'uc' => $uc,
            'docentes' => $docentes,
            'acns' => $acns
        ]);
    }
}
