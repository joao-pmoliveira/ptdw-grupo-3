<?php

namespace App\Http\Controllers;

use App\Models\ACN;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\UnidadeCurricular;
use Illuminate\Http\Request;

class AdminViewController extends Controller
{
    public function gerirDados() {
        $periodo=Periodo::where('ano', 2023)
            ->where('semestre', 1)
            ->first(); 
        
        $docentes=Docente::all();
        $acns=ACN::all();

        $ucs=UnidadeCurricular::where('periodo_id', $periodo->id)->get();
        return view('gerirDados', [
            'page_title' => 'Gerir Dados', 
            'ucs' => $ucs,
            'docentes' => $docentes,
            'acns' => $acns
        ]);
        
    }
}
