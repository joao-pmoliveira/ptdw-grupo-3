<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;

class DocenteViewController extends Controller
{
    public function editarDocente(Docente $docente) {
        return view('docente', [
            'page_title' => 'Docente',
            'docente' => $docente
        ]);
    }
}
