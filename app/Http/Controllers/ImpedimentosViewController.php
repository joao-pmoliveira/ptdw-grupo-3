<?php

namespace App\Http\Controllers;

use App\Models\Impedimento;
use Illuminate\Http\Request;

class ImpedimentosViewController extends Controller
{
    public function impedimentos($ano_inicial, $ano_final, $semestre) {
        return view('impedimento', [
            'page_title' => 'Impedimentos de Horário',
            'ano_inicial' => $ano_inicial,
            'ano_final' => $ano_final,
            'semestre' => $semestre
        ]);

    }
}
