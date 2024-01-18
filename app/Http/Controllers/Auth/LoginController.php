<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function show()
    {
        return view('login', ['page_title' => 'Login']);
    }

    public function authenticate(Request $request)
    {
        try {
            // todo @joao: adicionar 'remember_me' option
            $rules = [
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => ['required'],
            ];

            $messages = [
                'email.required' => 'Insira o seu email!',
                'email.email' => 'Email inválido!',
                'email.exists' => 'Email não está associado a um docente! Crie nova conta!',
                'password.required' => 'Insira a password!',
            ];

            $credentials = Validator::make($request->all(), $rules, $messages)->validate();
            $rememberMe = false;
            if (Auth::attempt($credentials, $rememberMe)) {
                $request->session()->regenerate();
                return redirect()->intended(route('inicio.view'));
            } else {
                return redirect()->back()->with('alerta', 'Email ou password errados!');
            }
        } catch (ValidationException $e) {
            return redirect()->back()->with('alerta', $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect()->route('welcome.view');
    }
}
