<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistoController extends Controller
{
    public function show()
    {
        return view('registo', ['page_title' => 'Registar Conta']);
    }

    public function register(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email'],
            'numero_funcionario' => ['required'],
            'password' => ['required']
        ]);

        $docente = Docente::where('numero_funcionario', $request->input('numero_funcionario'))->first();

        if ($docente) {
            $user = $docente->user;

            $user->update([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

            return response()->json([
                'message' => 'Docente associado com sucesso',
            ]);
        } else {
            return response()->json(['error' => 'Número de funcionário não existe'], 404);
        }
    }
}
