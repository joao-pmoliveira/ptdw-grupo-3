<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Impedimento;
use App\Models\UnidadeCurricular;
use App\Models\Periodo;
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
            'historico_impedimentos' => $historico_impedimentos,
            'historico_ucs' => $historico_ucs,
            'user' => $user,
        ]);
    }

    public function restricoesUC(UnidadeCurricular $uc, $ano_inicial, $semester)
    {
        //todo se utilizador não está associado a esta UC,
        //recusar acesso à página
        //se utilizador não é responsavel por uc, nao deixar editar

        return view('restrição', [
            'page_title' => 'Restrições de Sala de Aula',
            'uc' => $uc,
            'ano_inicial' => $ano_inicial,
            'semestre' => $semester,
            'user' => Auth::user(),
        ]);
    }

    public function recolha()
    {
        $user = Auth::user();

        if (Gate::denies('admin-access')) {
            abort(403, 'Sem autorização');
        }

        return view('processos', [
            'page_title' => 'Recolha de Restrições',
            'user' => $user,
        ]);
    }
}
