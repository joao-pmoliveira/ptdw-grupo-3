@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
            ['página inicial', route('inicio.view')],
            ['gerir dados', route('admin.gerir.view')],
            ['adicionar docente', route('docente.adicionar.view')]
        ]
    ])

    @include('partials._pageTitle', ['title' => 'Adicionar Docente'])


    <section class="mt-3 title-separator  pt-2">
        @include('partials._alerts')
        
        <form id="add-docente-form" action="{{route('docentes.store')}}" method="POST">
            @csrf
            <div class="d-flex align-items-center p-2">
                <label for="numero" class="col-md-2">Número</label>
                <input type="number" name="numero" id="docente-numero-input" class="col-md-2 px-1" required min="0">
            </div>

            <hr class="m-0 bg-secondary">

            <div class="d-flex align-items-center p-2">
                <label for="nome" class="col-md-2">Nome</label>
                <input type="text" name="nome" id="docente-nome-input" class="col-md-4 px-1" required>
            </div>

            <hr class="m-0 bg-secondary">

            <div class="d-flex align-items-center p-2">
                <label for="email" class="col-md-2">Email</label>
                <input type="email" name="email" id="docente-email-input" class="col-md-4 px-1">
            </div>

            <hr class="m-0 bg-secondary">

            <div class="d-flex align-items-center p-2">
                <label for="telemovel" class="col-md-2">Telemóvel</label>
                <input type="tel" name="telemovel" id="docente-telemovel" class="col-md-4 px-1">
            </div>

            <hr class="m-0 bg-secondary">
            
            <div class="d-flex align-items-center p-2">
                <label class="col-md-2" for="acn">Área Científica</label>
                <select class="col-md-2 p-1" name="acn" id="ucn-acn-select" required>
                    <option value="" selected>---</option>
                    @foreach ($acns as $acn)
                        <option value="{{$acn->id}}">{{$acn->nome}}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex align-items-center gap-2">
                <input class="btn" type="submit" value="Submeter">
                <a class="btn cancelar" href="{{route('admin.gerir.view')}}" value="Cancelar">Cancelar</a>
            </div>
        </form>
    </section>

</main>

@endsection