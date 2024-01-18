<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ACN;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only('perfil');
    }

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
        try {
            $rules = [
                'nome' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['nullable'],
            ];

            $messages = [
                'nome.required' => 'Preencha o seu nome!',
                'email.required' => 'Preencha o seu email!',
                'email.email' => 'Email inválido!',
            ];

            $validatedData = Validator::make($request->all(), $rules, $messages)->validate();

            DB::beginTransaction();

            $updatedData = [
                'nome' => $validatedData['nome'],
                'email' => $validatedData['email'],
            ];

            if (isset($validatedData['password'])) {
                $updatedData['password'] = bcrypt($validatedData['password']);
            }

            $user = User::find(Auth::user()->id);
            $user->update($updatedData);

            DB::commit();
            return redirect()->back()->with('sucesso', 'Alterações bem sucedidas!');
        } catch (ValidationException $e) {
            return redirect()->back()->with('alerta', $e->getMessage());
        }
    }
}
