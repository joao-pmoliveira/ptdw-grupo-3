<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Impedimento;
use Illuminate\Http\Request;

class ImpedimentosViewController extends Controller
{
    public function impedimentos(Docente $docente, $ano_inicial, $semestre)
    {
        return view('impedimento', [
            'page_title' => 'Impedimentos de Horário',
            'ano_inicial' => $ano_inicial,
            'semestre' => $semestre,
            'docente' => $docente
        ]);
    }
}
