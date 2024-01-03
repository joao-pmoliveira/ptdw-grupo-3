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
        <form action="" method="POST" class="title-separator pt-3">
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="docente-numero" class="col-md-2 p-3">Número</label>
                <input type="number" name="docente-numero" id="docente-numero-input" class="col-md-2 p-1" 
                    value="{{$docente->numero_funcionario}}" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="docente-nome" class="col-md-2 p-3">Nome</label>
                <input type="text" name="docente-nome" id="docente-nome-input" class="col-md-4 p-1"
                    value="{{$docente->user->nome}}" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="docente-email" class="col-md-2 p-3">Email</label>
                <input type="email" name="docente-email" id="docente-email-input" class="col-md-4 p-1"
                    value="{{$docente->user->email}}" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="docente-telemovel" class="col-md-2 p-3">Telemóvel</label>
                <input type="tel" name="docente-telemovel" id="docente-telemovel" class="col-md-4 p-1"
                    value="{{$docente->numero_telefone}}" required>
            </div>
            <div class="d-flex align-items-center border border-dark p-2 mb-2">
                <label for="docente-acn" class="col-md-2 p-3">Área Científica</label>
                <input type="text" name="docente-acn" id="docente-acn-input" class="col-md-4 p-1"
                    value="{{$docente->acn->sigla}}" required>
            </div>
            <div class="d-flex align-items-center gap-2">
                <input class="btn" type="button" value="Confirmar">
                <input class="btn" type="button" value="Remover">
                <input class="btn" type="button" value="Cancelar">
            </div>
        </form>
    </section>
</main>
@endsection