<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DocenteViewController;
use App\Http\Requests\DocenteRequest;
use App\Models\Docente;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\TestMail;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DocenteController extends Controller
{
    public function index()
    {
        try {
            $docentes = Docente::all();
            return response()->json($docentes, 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function show(Docente $docente)
    {
        try {
            return response()->json($docente, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Docente não encontrado'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->authorize('admin-access');

            $rules = [
                'nome' => ['required', 'string'],
                'acn' => ['required', 'integer', 'exists:acns,id'],
                'email' => ['required', 'email'],
                'telemovel' => ['nullable', 'string'],
                'numero' => ['required', 'integer', 'min:1', 'unique:users,numero_funcionario'],
            ];

            $messages = [
                'nome.required' => 'Preencha o nome do Docente!',
                'nome.string' => 'Nome do docente inválido!',
                'acn.required' => 'Selecione a Área Científica Nuclear do Docente!',
                'acn.integer' => 'Área Científica Nuclear do Docente inválida!',
                'acn.exists' => 'Área Científica Nuclear do Docente inválida!',
                'email.required' => 'Preencha o email do Docente!',
                'email.email' => 'Email do docente inválido!',
                'telemovel.string' => 'Número de telefone do Docente inválido!',
                'numero.required' => 'Preencha o número de funcionário!',
                'numero.integer' => 'Número de funcionário inválido!',
                'numero.min' => 'Número de funcionário tem de ser superior a 1!',
                'numero.unique' => 'Número de funcionário já está em uso!',
            ];

            $validatedData = Validator::make($request->all(), $rules, $messages)->validate();

            $nome = $validatedData['nome'];
            $numero = $validatedData['numero'];
            $email = $validatedData['email'];
            $telemovel = $validatedData['telemovel'];
            $acn = $validatedData['acn'];

            DB::beginTransaction();

            $docente = Docente::create([
                'acn_id' => $acn,
            ]);
            $docente->save();

            $user = User::create([
                'nome' => $nome,
                'email' => $email,
                'password' => bcrypt('password'),
                'admin' => false,
                'numero_funcionario' => $numero,
                'numero_telefone' => $telemovel,
            ]);
            $docente->user()->save($user);

            // todo @joao:
            Mail::to('miguelmvieira@ua.pt')->send(new TestMail());

            DB::commit();
            return redirect(route('admin.gerir.view'))->with('sucesso', 'Adicionado docente com sucesso!');
        } catch (AuthorizationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', 'Sem permissões para adicionar Docente!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->authorize('admin-access');

            $docente = Docente::findOrFail($id);

            $rules = [
                'nome' => ['required', 'string'],
                'acn' => ['required', 'integer', 'exists:acns,id'],
                'email' => ['required', 'email'],
                'telefone' => ['nullable'],
                'numero_funcionario' => ['required', 'integer', 'min:1'],
            ];

            $messages = [
                'nome.required' => 'Preencha o nome do docente!',
                'nome.string' => 'Nome do docente inválido!',
                'acn.required' => 'Selecione a Área Científica Nuclear do docente!',
                'acn.integer' => 'Área Científica Nuclear inválida!',
                'acn.exists' => 'Área Científica Nuclear inválida!',
                'email.required' => 'Preencha o email do docente!',
                'email.email' => 'Email inválido',
                'numero_funcionario.required' => 'Preencha o número de funcionário!',
                'numero_funcionario.integer' => 'Número de funcionário tem de ser número inteiro!',
                'numero_funcionario.min' => 'Número de funcionário tem de ser superior a 1!',
            ];

            $validatedData = Validator::make($request->all(), $rules, $messages)->validate();

            $docente->update([
                'acn_id' => $validatedData['acn'],
            ]);

            $docente->user->update([
                'nome' => $validatedData['nome'],
                'email' => $validatedData['email'],
                'numero_funcionario' => $validatedData['numero_funcionario'],
                'numero_telefone' => $validatedData['telefone'],
            ]);

            DB::commit();
            return redirect()->back()->with('sucesso', 'Docente editado com sucesso!');
        } catch (AuthorizationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', 'Sem permissões para editar Docente!');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', 'Erro ao submeter edições!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->authorize('admin-access');

            $docente = Docente::findOrFail($id);

            if ($docente->user->id == Auth::user()->id) {
                throw new Exception('Não é possível remover o docente associado a esta conta!');
            }

            DB::beginTransaction();

            $docente->user->delete();
            $docente->impedimentos()->delete();
            $docente->unidadesCurriculares()->detach();
            foreach ($docente->ucsResponsavel as $uc) {
                $uc->docente_responsavel_id = null;
                $uc->save();
            }
            $docente->delete();

            DB::commit();
            return redirect(route('admin.gerir.view'))->with('sucesso', 'Docente removido com sucesso!');
        } catch (AuthorizationException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', 'Sem permissões para remover Docente!');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', 'Erro ao tentar remover docente!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('alerta', $e->getMessage());
        }
    }
}
