<?php

namespace App\Http\Controllers;

use App\Models\UnidadeCurricular;
use Illuminate\Http\Request;

class RestricoesViewController extends Controller
{
    public function restricoes() {

        return view('restrições', ['page_title' => 'Restrições']);
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
