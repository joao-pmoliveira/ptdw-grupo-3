<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DocenteViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function editarDocente(Docente $docente)
    {
        $user = Auth::user();

        if (Gate::denies('admin-access')) {
            abort(403, 'Sem Autorização');
        }

        return view('docente', [
            'page_title' => 'Docente',
            'docente' => $docente,
            'user' => Auth::user(),
        ]);
    }
}
