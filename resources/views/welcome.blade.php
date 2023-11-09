@extends('layouts.base')

@section('main')
<main>
    <nav class="navbar navbar-main navbar-expand-lg px-3 shadow-none ">
        <div class="container-fluid d-flex justify-content-end">
            <button>Entrar</button>
        </div>
    </nav>
    <div class="container-fluid d-flex align-items-center p-3 gap-3 bg-accent">
        <i class="fa-solid fa-bars text-light"></i>
        <div class="img-wrapper">
            <img src="{{ asset('img/Logo.png') }}" alt="">
        </div>
    </div>

    <div id="hero" class="m-3 p-4">
        <h1 class="text-light">suporte à criação de horários da estga</h1>
    </div>


</div>
</main>
@endsection