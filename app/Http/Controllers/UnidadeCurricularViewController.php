<?php

namespace App\Http\Controllers;

use App\Models\ACN;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\UnidadeCurricular;
use Illuminate\Http\Request;

class UnidadeCurricularViewController extends Controller
{
    public function unidadesCurriculares()
    {
        $periodos = Periodo::orderBy('ano', 'desc')
            ->orderBy('semestre', 'desc')
            ->get();

        $unidadesCurriculares = UnidadeCurricular::where("periodo_id", $periodos[0]->id)
            ->get();

        return view('unidadesCurriculares', [
            'page_title' => 'Consultar Unidades Curriculares',
            'periodos' => $periodos,
            'ucs' => $unidadesCurriculares,
        ]);
    }

    public function unidadeCurricular(UnidadeCurricular $uc)
    {
        return view('unidadeCurricular', [
            'page_title' => 'Unidade Curricular',
            'uc' => $uc
        ]);
    }

    public function editarUnidadeCurricular(UnidadeCurricular $uc)
    {
        $acns = ACN::all();
        $docentes = Docente::all();
        return view('editarUnidadeCurricular', [
            'page_title' => 'Unidade Curricular',
            'uc' => $uc,
            'docentes' => $docentes,
            'acns' => $acns
        ]);
    }
}
