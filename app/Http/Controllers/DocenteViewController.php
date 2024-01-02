<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function editarDocente(Docente $docente)
    {
        return view('docente', [
            'page_title' => 'Docente',
            'docente' => $docente,
            'user' => Auth::user(),
        ]);
    }
}
