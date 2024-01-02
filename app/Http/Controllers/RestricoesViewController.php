<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Impedimento;
use App\Models\UnidadeCurricular;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //todo: ir para view apenas se for admin
        return view('processos', [
            'page_title' => 'Recolha de Restrições',
            'user' => Auth::user(),
        ]);
    }
}
