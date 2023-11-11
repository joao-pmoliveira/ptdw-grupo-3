@extends('layouts.base')

@section('body')

<div class="vh-100 d-flex flex-column">

    @include('partials._topBar')

    @include('partials._logoBar', ['sidebar' => true])
    <div class="d-flex h-100">
        @include('partials._sidebar')

        @yield('main')

    </div>

</div>

@endsection