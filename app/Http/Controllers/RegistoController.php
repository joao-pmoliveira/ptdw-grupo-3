<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Docente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class RegistoController extends Controller
{
    public function show()
    {
        return view('registo', ['page_title' => 'Registar Conta']);
    }

    public function register(Request $request)
    {
        try {
            $rules = [
                'email' => ['required', 'email'],
                'numero_funcionario' => ['required', 'exists:users,numero_funcionario'],
                'password' => ['required'],
            ];

            $messages = [
                'email.required' => 'Insira o seu email!',
                'email.email' => 'Email inválido!',
                'numero_funcionario.required' => 'Insira o seu número de funcionário!',
                'numero_funcionario.exist' => 'Número de funcionário inválido!',
                'password.required' => 'Insira a sua password!',
            ];

            $validatedData = Validator::make($request->all(), $rules, $messages)->validate();

            $user = User::where('numero_funcionario', $validatedData['numero_funcionario'])->first();

            if (!$user) {
                throw new Exception('Erro ao associar conta!');
            }

            DB::beginTransaction();

            //$user = $docente->user;

            // todo @joao: verificar se este user já não tem os dados
            // se já tiver os dados, é porque já foi associado
            if (!empty($user->email)) {
                return redirect(route('registo.view'))->with('alerta', 'O Número de Funcionário já se encontra atribuído!');
            }
            $user->update([
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'email_verificado_a'=>Carbon::now()->toDateTimeString(),
            ]);

            DB::commit();
            return redirect(route('login.view'))->with('sucesso', 'Sucesso na associação de conta!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', $e->getMessage());
        }
    }
}
