@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => []
    ])

    @include('partials._pageTitle', ['title' => 'Suporte à Criação de Horários'])

    <section class="mt-3">
        @if ($user->docente)
        <h2 class="m-2 text-terciary">Docente</h2>
        <div class="d-flex flex-wrap gap-4">
            @include('partials._card', [
                    'title' => 'Unidades Curriculares',
                    'body' => ['Consulta da lista de Unidades Curriculares'],
                    'button' => 'Consultar',
                    'url' => route('ucs.view')
                ])
            @include('partials._card', [
                    'title' => 'Preencher Restrições',
                    'body' => [
                            'Prenchimento de impedimentos de horários e restrições de sala',
                        ],
                    'button' => 'Preencher',
                    'url' => route('restricoes.view')
                ])
        </div>
        @endif
    </section>
    
    @if ($user->admin && $user->docente)
        <hr>
    @endif
    
    <section class="mt-3">
        @if ($user->admin)
        <h2 class="m-2 text-terciary">Admin</h2>
        <div class="d-flex flex-wrap gap-4">
            @include('partials._card', [
                    'title' => 'Recolha de Restrições',
                    'body' => [
                            'Criação de um novo processo e verificação do mesmo',
                            'Descarregar dados de restrições'
                        ], 
                    'button' => 'Gerir',
                    'url' => route('restricoes.recolha.view')
                ])
            @include('partials._card', [
                    'title' => 'Gerir Dados',
                    'body' => [
                            'Adicionar, editar ou remover Unidades Curriculares e docentes;',
                            'Importar dados serviço-docente;'
                        ],
                    'button' => 'Gerir',
                    'url' => route('admin.gerir.view')
                ])
        </div>
        @endif
    </section>
    <section class="mt-3" hidden>
        @include('partials._card', [
                'title' => 'Ajuda',
                'body' => [
                        'Consulta de guias e FAQs',
                    ],
                'button' => 'Consultar',
                'url' => route('inicio.view')
            ])
    </section>
        
        
        

</main>

@endsection