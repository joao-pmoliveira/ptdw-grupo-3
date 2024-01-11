<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Impedimento;
use App\Models\UnidadeCurricular;
use App\Models\Periodo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RestricoesViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function restricoes()
    {
        $user = Auth::user();

        if (!$user->docente) {
            return redirect()->route('inicio.view');
        }

        $periodo = Periodo::orderBy('ano', 'desc')
            ->orderBy('semestre', 'desc')
            ->first();

        $ucs = $user->docente->unidadesCurriculares()
            ->where('periodo_id', $periodo->id)
            ->get();

        $impedimento = $user->docente->impedimentos()->where('periodo_id', $periodo->id)->first();

        $historico_ucs = $user->docente->unidadesCurriculares()
            ->where('periodo_id', '!=', $periodo->id)
            ->get()
            ->sortByDesc(function ($item) {
                return $item->periodo->ano * 10 + $item->periodo->semestre;
            });

        $historico_impedimentos = $user->docente->impedimentos()
            ->where('periodo_id', '!=', $periodo->id)
            ->get()
            ->sortByDesc(function ($item) {
                return $item->periodo->ano * 10 + $item->periodo->semestre;
            });

        return view('restrições', [
            'page_title' => 'Restrições',
            'periodo' => $periodo,
            'ucs' => $ucs,
            'impedimento' => $impedimento,
            'historico_impedimentos' => $historico_impedimentos,
            'historico_ucs' => $historico_ucs,
            'user' => $user,
        ]);
    }

    public function restricoesUC(UnidadeCurricular $uc, $ano_inicial, $semestre)
    {

        if (Gate::denies('access-uc-restricoes', $uc)) {
            return redirect()->back();
        }

        //todo se utilizador não está associado a esta UC,
        //recusar acesso à página
        //se utilizador não é responsavel por uc, nao deixar editar

        return view('restrição', [
            'page_title' => 'Restrições de Sala de Aula',
            'uc' => $uc,
            'ano_inicial' => $ano_inicial,
            'semestre' => $semestre,
            'user' => Auth::user(),
        ]);
    }

    public function recolha()
    {
        $user = Auth::user();

        if (Gate::denies('admin-access')) {
            abort(403, 'Sem autorização');
        }

        //buscar periodo mais recente
        //por cada docente ver uc responsaveis e ver se já estar preenchido/submitido
        //por cada docente ver impedimentos e ver se está preenchido submetido 

        $periodos = Periodo::orderBy('ano', 'desc')
            ->orderBy('semestre', 'desc')
            ->get();

        $docentes = Docente::orderBy('numero_funcionario', 'desc')
            ->get();

        return view('processos', [
            'page_title' => 'Recolha de Restrições',
            'user' => $user,
            'docentes' => $docentes,
            'periodo' => $periodos[0],
            'periodosH' => $periodos->slice(1),
        ]);
    }
}
