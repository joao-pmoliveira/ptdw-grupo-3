@extends('layouts.base')

@section('body')
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

        <section class="py-3 py-md-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                        <div class="card border border-light-subtle rounded-3 shadow-sm custom-width" style="width: 110%;">
                            <div class="card-body p-3 p-md-4 p-xl-5">
                                <h1 class="page-title justify-content-center">Associar Conta</h1><br>
                                <form action="{{route('registo.action')}}" method="POST" id="registo-form">
                                    @csrf
                                    <div class="row gy-3 overflow-hidden">
                                        <div class="col-12">
                                            <div class="form-floating mb-3 border border-2 rounded">
                                                <label for="user-email-input" class="form-label">Email</label>
                                                <input type="email" class="form-control border-0" name="email" id="user-email-input" placeholder="name@example.com" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-3 border border-2 rounded">
                                                <label for="user-codigo-input" class="form-label">Número funcionário</label>
                                                <input type="number" class="form-control border-0" name="codigo" id="user-codifo-input" placeholder="name@example.com" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-3 border border-2 rounded">
                                                <label for="user-password-input" class="form-label">Password</label>
                                                <input type="password" class="form-control border-0" name="password" id="user-password-input" value="" placeholder="Password" required>
                                            </div>
                                        </div>
                                        <div class="col-12 justify-content-center">
                                            <div class="d-grid my-3 justify-content-center">
                                                <button class="btn" style="width:10rem;">Registar</button>
                                            </div>
                                            <div class="d-grid my-3 justify-content-center">
                                                <a class="btn" style="width:10rem;" href="{{route('inicio.view')}}">Cancelar</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection