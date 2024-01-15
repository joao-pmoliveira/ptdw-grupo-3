@extends('layouts.base')


<main class="mw-100">
    <nav class="navbar navbar-main navbar-expand-lg px-3 shadow-none ">
        <div class="container-fluid d-flex justify-content-end">
            <a href="{{route('inicio.view')}}" class="sm m-0 px-2 py-1 text-terciary bg-primary border-0
                text-accent login-txt">
                    entrar
                    <i class="fa-solid fa-user"></i>
            </a>
        </div>
    </nav>
    @include('partials._header', ['sidebar' => false])

    <div id="hero" class="m-3 p-4" style="background-image: url({{asset('/img/bg-hero.jpg')}});">
        <h1 class="text-light">suporte à criação de horários da estga</h1>
    </div>


</div>
</main>
@endsection