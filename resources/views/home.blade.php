@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                ['página Inicial', '/'],
                ['teste', '/home']
            ]
    ])

    @include('partials._pageTitle', ['title' => 'Suporte à Criação de Horários'])

    <section class="mt-5 d-flex flex-wrap gap-4">
        @include('partials._card', [
                'title' => 'Unidades Curriculares',
                'body' => ['Consulte a lista de Unidades Curriculares'],
                'button' => 'Consultar'
            ])
        @include('partials._card', [
                'title' => 'Preencher Restrições',
                'body' => [
                        'Verifique formulários pendentes;',
                        'Preencha os seus impedimentos de horário para o próximo semestre;',
                        'Preencha as restrições de salas para cada UC em que é docente responsável;',
                        'Consultar histórico de formulários.'
                    ],
                'button' => 'Preencher'
            ])
        @include('partials._card', [
                'title' => 'Gerir Processos',
                'body' => [
                        'Criar novo processo(inclui a disponibilização ao docentes,
                            dos formulários de impedimentos de horário, e restrições de sala);',
                        'Verificar estado do processo;',
                        'Descarregar dados de restrições submetidos;',
                        'Consultar histórico dos processos;'
                    ], 
                'button' => 'Gerir'
            ])
        @include('partials._card', [
                'title' => 'Gerir Dados',
                'body' => [
                        'Adicione, edite ou remova Unidades Curriculares;',
                        'Adicione, edite ou remova docentes;',
                        'Importe dados do ficheiro do Serviço de Docentes;'
                    ],
                'button' => 'Gerir'
            ])
        @include('partials._card', [
                'title' => 'Ajuda',
                'body' => [
                        'Consulte os guias',
                        'Consulte os FAQs'
                    ],
                'button' => 'Consultar'
            ])

    </section>
</main>

@endsection