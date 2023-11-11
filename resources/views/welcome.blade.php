@extends('layouts.base')

@section('main')
<main>
    <nav class="navbar navbar-main navbar-expand-lg px-3 shadow-none ">
        <div class="container-fluid d-flex justify-content-end">
            <button class="sm m-0 px-2 py-1 text-terciary bg-primary border-0
                text-accent login-text" type="button">
                    entrar
                    <i class="fa-solid fa-user"></i>
            </button>
        </div>
    </nav>
    @include('partials._logoBar')

    <div id="hero" class="m-3 p-4">
        <h1 class="text-light">suporte à criação de horários da estga</h1>
    </div>


</div>
</main>
@endsection