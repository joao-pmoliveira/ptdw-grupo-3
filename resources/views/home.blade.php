@extends('layouts.baseContent')

@section('content')

<div class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                ['página Inicial', '/'],
                ['teste', '/home']
            ]
    ])

    @include('partials._pageTitle', ['title' => 'Suporte à Criação de Horários'])
</div>

@endsection