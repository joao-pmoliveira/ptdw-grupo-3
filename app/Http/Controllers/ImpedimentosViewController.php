<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Impedimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ImpedimentosViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function impedimentos(Docente $docente, $ano_inicial, $semestre)
    {

        $user = Auth::user();
        if (Gate::denies('acess-docente-impedimentos', $docente)) {
            return back();
        }

        return view('impedimento', [
            'page_title' => 'Impedimentos de Horário',
            'ano_inicial' => $ano_inicial,
            'semestre' => $semestre,
            'docente' => $docente,
            'user' => $user,
        ]);
    }
}
