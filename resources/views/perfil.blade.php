@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
            ['página inicial', route('inicio.view')],
            [$user->nome, route('perfil.view')]
        ]
    ])


@include('partials._pageTitle', ['title' => $user->nome])

    <section class="mt-3 title-separator pt-2">
        <section id="alerts">
            @if (session('alerta'))
                <div class="alert alert-dismissible fade show bg-alert" role="alert">
                    <p>
                        <i class="fa-solid fa-check"></i>
                        {{session('alerta')}}
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa-solid fa-x"></i>
                    </button> 
                </div>
            @endif
            @if (session('sucesso'))
                <div class="alert alert-dismissible fade show bg-accent" role="alert">
                    <p>
                        <i class="fa-solid fa-check"></i>
                        {{session('sucesso')}}
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa-solid fa-x"></i>
                    </button> 
                </div>
            @endif
        </section>

        <form id="edit-perfil-form" action="{{route('perfil.edit.view')}}" method="POST">
            @csrf   
            <div class="d-flex align-items-center p-2">
                <label for="user-nome" class="col-md-2 ">Nome</label>
                <input type="text" name="nome" id="user-nome-input" class="col-md-4 px-1" value="{{$user->nome}}" required>
            </div>

            <hr class="m-0 bg-secondary">
            
            <div class="d-flex align-items-center p-2">
                <label for="user-email" class="col-md-2 ">Email</label>
                <input type="email" name="email" id="user-email-input" class="col-md-4 px-1" value="{{$user->email}}" required>
            </div>

            <hr class="m-0 bg-secondary">

            <div class="d-flex align-items-center p-2">
                <label for="user-password" class="col-md-2 ">Password</label>
                <input type="password" name="password" id="docente-password" class="col-md-2 px-1" value="">
            </div>
            
            <div class="d-flex gap-3 mt-3 mb-5">
                <input class="btn" type="submit" value="Editar">
                <a class="btn cancelar" href="{{route('inicio.view')}}" value="Cancelar">Cancelar</a>
            </div>
        </form>
    </section>
</main>
@endsection