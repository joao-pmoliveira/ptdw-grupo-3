<?php

namespace App\Http\Controllers;

use App\Models\Impedimento;
use App\Models\UnidadeCurricular;
use App\Models\Periodo;
use Illuminate\Http\Request;

class RestricoesViewController extends Controller
{
    public function restricoes() {

        $currentYear = date('Y');

        $ucsH = Periodo::where('ano', '!=', $currentYear)->firstOrFail()->unidadesCurriculares;
        $ucs = Periodo::where('ano', $currentYear)->firstOrFail()->unidadesCurriculares;
        $impedimentos = Impedimento::whereHas('periodo', function ($query) use ($currentYear) {
            $query->where('ano', '!=', $currentYear);
        })->get();

        return view('restrições', [
            'page_title' => 'Restrições',
            'ucs' => $ucs,
            'impedimentos' => $impedimentos,
            'ucsH' => $ucsH
        ]);
    }

    public function restricoesUC(UnidadeCurricular $uc, $ano_inicial, $ano_final, $semester) {
        return view('restrição', [
            'page_title' => 'Restrições de Sala de Aula',
            'uc' => $uc,
            'ano_inicial' => $ano_inicial,
            'ano_final' => $ano_final,
            'semestre' => $semester
        ]);
    }

    public function recolha() {
        return view('processos', ['page_title' => 'Recolha de Restrições']);
    }
}
