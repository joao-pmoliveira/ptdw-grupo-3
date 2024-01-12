<?php

namespace App\Http\Controllers;

use App\Models\ACN;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\UnidadeCurricular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnidadeCurricularViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function unidadesCurriculares()
    {
        $user = Auth::check() ? Auth::user() : NULL;

        $periodos = Periodo::orderBy('ano', 'desc')
            ->orderBy('semestre', 'desc')
            ->get();

        $unidadesCurriculares = UnidadeCurricular::where("periodo_id", $periodos[0]->id)
            ->orderByRaw('CAST(codigo as INTEGER) asc')
            ->get();

        return view('unidadesCurriculares', [
            'page_title' => 'Consultar Unidades Curriculares',
            'periodos' => $periodos,
            'ucs' => $unidadesCurriculares,
            'user' => $user,
        ]);
    }

    public function unidadeCurricular(UnidadeCurricular $uc)
    {
        $user = Auth::check() ? Auth::user() : NULL;

        return view('unidadeCurricular', [
            'page_title' => 'Unidade Curricular',
            'uc' => $uc,
            'user' => $user,
        ]);
    }

    public function editarUnidadeCurricular(UnidadeCurricular $uc)
    {
        $user = Auth::check() ? Auth::user() : NULL;
        $acns = ACN::all();
        $docentes = Docente::all();
        return view('editarUnidadeCurricular', [
            'page_title' => 'Unidade Curricular',
            'uc' => $uc,
            'docentes' => $docentes,
            'acns' => $acns,
            'user' => $user,
        ]);
    }

    public function addUnidadeCurricular()
    {
        $user = Auth::check() ? Auth::user() : NULL;
        $acns = ACN::all();
        $docentes = Docente::all();
        return view('addUnidadeCurricular', [
            'page_title' => 'Adicionar Unidade Curricular',
            'docentes' => $docentes,
            'acns' => $acns,
            'user' => $user,
        ]);
    }
}
