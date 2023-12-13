@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                //['página inicial', '/inicio']
            ]
    ])

    @include('partials._pageTitle', ['title' => 'Suporte à Criação de Horários'])

    <section class="mt-5 d-flex flex-wrap gap-4">
        @include('partials._card', [
                'title' => 'Unidades Curriculares',
                'body' => ['Consulta da lista de Unidades Curriculares'],
                'button' => 'Consultar',
                'url' => '/ucs'
            ])
        @include('partials._card', [
                'title' => 'Preencher Restrições',
                'body' => [
                        'Prenchimento de impedimentos de horários e restrições de sala',
                    ],
                'button' => 'Preencher',
                'url' => '/restricoes'
            ])
        @include('partials._card', [
                'title' => 'Gerir Restrições',
                'body' => [
                        'Criação de um novo processo e verificação do mesmo',
                        'Descarregar dados de restrições submetidos'
                    ], 
                'button' => 'Gerir',
                'url' => '/processos'
            ])
        @include('partials._card', [
                'title' => 'Gerir Dados',
                'body' => [
                        'Adicionar, editar ou remover Unidades Curriculares e docentes;',
                        'Importar dados serviço-docente;'
                    ],
                'button' => 'Gerir',
                'url' => '/gerir'
            ])
        @include('partials._card', [
                'title' => 'Ajuda',
                'body' => [
                        'Consulta de guias e FAQs',
                    ],
                'button' => 'Consultar',
                'url' => '/inicio'
            ])

    </section>
</main>

@endsection