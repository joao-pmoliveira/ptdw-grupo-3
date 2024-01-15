<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ACN;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PerfilController extends Controller
{

    public function perfil()
    {
        $user = Auth::user();

        return view('perfil', [
            'page_title' => 'Perfil',
            'user' => $user,
        ]);
    }

    public function editarPerfil(Request $request)
    {
        $request->validate([
            'nome' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['nullable']
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            $userData = [
                'nome' => $request->input('nome'),
                'email' => $request->input('email'),
            ];

            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->input('password'));
            }

            $user->update($userData);

            return response()->json([
                'message' => 'Perfil alterado com sucesso',
            ]);
        } else {
            return response()->json(['error' => 'Erro, perfil não modificado'], 404);
        }
    }
}
