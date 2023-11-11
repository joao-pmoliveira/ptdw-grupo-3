@extends('layouts.baseContent')

@section('content')

<div class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                ['página Inicial', '/'],
                ['teste', '/home']
            ]
    ])
    <h1>Test</h1>
</div>

@endsection