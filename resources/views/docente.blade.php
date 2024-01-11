@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
    'crumbs' => [
    ['página inicial', route('inicio.view')],
    ['gerir dados', route('admin.gerir.view')],
    [$docente->user->nome, route('docentes.editar.view', ['docente' => $docente->id])]
    ]
    ])

    @include('partials._pageTitle', ['title' => $docente->numero_funcionario . ' - ' . $docente->user->nome])

    <section class="mt-3">
        <form id="edit-docente-form" action="{{route('docentes.update', ['id' => $docente->id])}}" method="POST" class="title-separator pt-3">
            @csrf
            @method('PUT')
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="docente-numero" class="col-md-2 p-3">Número</label>
                <input type="number" name="numero" id="docente-numero-input" class="col-md-2 p-1" value="{{$docente->numero_funcionario}}" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="docente-nome" class="col-md-2 p-3">Nome</label>
                <input type="text" name="nome" id="docente-nome-input" class="col-md-4 p-1" value="{{$docente->user->nome}}" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="docente-email" class="col-md-2 p-3">Email</label>
                <input type="email" name="email" id="docente-email-input" class="col-md-4 p-1" value="{{$docente->user->email}}" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="docente-telemovel" class="col-md-2 p-3">Telemóvel</label>
                <input type="tel" name="telemovel" id="docente-telemovel" class="col-md-4 p-1" value="{{$docente->numero_telefone}}" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="docente-acn" class="col-md-2 p-3">Área Científica</label>
                <!--<input type="text" name="docente-acn" id="docente-acn-input" class="col-md-4 p-1" value="{{$docente->acn->sigla}}" required>-->
                <select class="col-md-2 p-1" name="acn" id="uc-acn-select" required>
                    <option value="{{$docente->acn->id}}" selected>{{$docente->acn->sigla}}</option>
                    @foreach ($acns as $acn)
                    @if ($acn->id !== $docente->acn->id)
                    <option value="{{$acn->id}}">{{$acn->sigla}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="d-flex align-items-center gap-2">
                <input class="btn" type="submit" value="Confirmar">
                <input class="btn" type="button" value="Remover">
                <a class="btn" href="{{route('admin.gerir.view')}}" value="Cancelar">Cancelar</a>
            </div>
        </form>
    </section>
</main>

@auth
    <script>
        const authUser = @json(auth()->user());
    </script>
@endauth
<script src="{{asset('js/editDocente.js')}}" defer></script>
@endsection