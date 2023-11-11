@extends('layouts.base')

@section('main')

<main class="vh-100 d-flex flex-column">

    @include('partials._topBar')

    @include('partials._logoBar', ['sidebar' => true])
    <div class="d-flex h-100">
        @include('partials._sidebar')

        @yield('content')

    </div>

</main>

@endsection