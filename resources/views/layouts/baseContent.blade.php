@extends('layouts.base')

@section('body')

<div id="primary-layout">

    @include('partials._loginBar')

    @include('partials._header', ['sidebar' => true])

    @include('partials._sidebar')

    @yield('main')

</div>

@endsection