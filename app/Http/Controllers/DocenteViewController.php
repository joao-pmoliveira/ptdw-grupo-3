<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\ACN;
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
        $acns = ACN::all();

        if (Gate::denies('admin-access')) {
            abort(403, 'Sem Autorização');
        }

        return view('docente', [
            'page_title' => 'Docente',
            'docente' => $docente,
            'acns' => $acns,
            'user' => Auth::user(),
        ]);
    }

    public function addDocente()
    {
        $user = Auth::check() ? Auth::user() : NULL;
        $acns = ACN::all();

        return view('addDocente', [
            'page_title' => 'Adicionar Docente',
            'acns' => $acns,
            'user' => $user,
        ]);
    }

}
