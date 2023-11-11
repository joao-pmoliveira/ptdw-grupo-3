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
</main>

@endsection