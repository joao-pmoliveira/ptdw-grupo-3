<?php

namespace App\Http\Controllers;

use App\Models\ACN;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\UnidadeCurricular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function gerirDados()
    {
        $user = Auth::user();

        if (Gate::denies('admin-access')) {
            return redirect(route('inicio.view'));
        }

        $periodos = Periodo::orderBy('ano', 'desc')
            ->orderBy('semestre', 'desc')
            ->get();

        $cursos = Curso::all();

        $docentes = Docente::all()->sortBy(function ($docente) {
            return $docente->user->numero_funcionario;
        });

        $acns = ACN::all();

        $dataType = getenv('DB_CONNECTION') === 'mysql' ? 'UNSIGNED' : 'INTEGER';
        $ucs = UnidadeCurricular::where("periodo_id", $periodos[0]->id)
            ->orderByRaw('CAST(codigo as ' . $dataType . ') asc')
            ->get();

        return view('gerirDados', [
            'page_title' => 'Gerir Dados',
            'ucs' => $ucs,
            'periodos' => $periodos,
            'cursos' => $cursos,
            'docentes' => $docentes,
            'acns' => $acns,
            'user' => $user,
        ]);
    }
}
