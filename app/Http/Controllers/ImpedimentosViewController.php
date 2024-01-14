<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Impedimento;
use App\Models\Periodo;
use Carbon\Carbon;
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

        $periodo = Periodo::where('ano', $ano_inicial)
            ->where('semestre', $semestre)
            ->first();

        $hoje = Carbon::now();
        $data_inicial = Carbon::createFromFormat('Y-m-d', $periodo->data_inicial);
        $data_final = Carbon::createFromFormat('Y-m-d', $periodo->data_final);

        $editavel = $hoje->lt($data_final) && $hoje->gt($data_inicial);

        $impedimento = $user->docente->impedimentos()
            ->where('periodo_id', $periodo->id)
            ->first();

        return view('impedimento', [
            'page_title' => 'Impedimentos de Horário',
            'ano_inicial' => $ano_inicial,
            'semestre' => $semestre,
            'docente' => $docente,
            'user' => $user,
            'impedimento' => $impedimento,
            'editavel' => $editavel,
        ]);
    }
}
