@extends('layouts.base')

@section('body')

<div id="primary-layout">

    <style>
        body {
            padding-top: 100px;
            height: 600px;
        }

    </style>

    <div id="body" class="fixed-top">

    @include('partials._loginBar')

    @include('partials._header', ['sidebar' => true])

    </div>

    <div class="content" id="content">@include('partials._sidebar')</div>

    @yield('main')
    

</div>

@endsection