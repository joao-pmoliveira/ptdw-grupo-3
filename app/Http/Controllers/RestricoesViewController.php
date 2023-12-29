<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Impedimento;
use App\Models\UnidadeCurricular;
use App\Models\Periodo;
use Illuminate\Http\Request;

class RestricoesViewController extends Controller
{
    public function restricoes()
    {
        //para efeitos de teste, associar que docente é Margarida Neves de Macedo
        //todo: substituir depois com base na conta do docente (com base no id/num_funcionario)
        $docente = Docente::where('nome', 'Margarida Neves de Macedo')->first();

        $periodo = Periodo::orderBy('ano', 'desc')
            ->orderBy('semestre', 'desc')
            ->first();

        $ucs = $docente->unidadesCurriculares()
            ->where('periodo_id', $periodo->id)
            ->get();

        $historico_ucs = $docente->unidadesCurriculares()
            ->where('periodo_id', '!=', $periodo->id)
            ->get()
            ->sortByDesc(function ($item) {
                return $item->periodo->ano * 10 + $item->periodo->semestre;
            });

        $historico_impedimentos = $docente->impedimentos()
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
        ]);
    }

    public function restricoesUC(UnidadeCurricular $uc, $ano_inicial, $semester)
    {
        return view('restrição', [
            'page_title' => 'Restrições de Sala de Aula',
            'uc' => $uc,
            'ano_inicial' => $ano_inicial,
            'semestre' => $semester
        ]);
    }

    public function recolha()
    {
        return view('processos', ['page_title' => 'Recolha de Restrições']);
    }
}
