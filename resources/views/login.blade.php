<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('css/material-dashboard.css')}}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="https://kit.fontawesome.com/db18a4139a.js" crossorigin="anonymous" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"
        defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
</head>

<body>
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
    <br>
    <main class="w-100 px-5">
        @include('partials._pageTitle', ['title' => 'Login'])
        <br>
        <div class="border border-dark p-3 container">
            <form action="{{route('login.action')}}" method="post" id="formLogin">
                @csrf
                <div class="row p-2">
                    <label class="col-md-2 col-sm-12" for="user-email-input">Email:</label>
                    <input class="col-md-5 col-sm-8" type="email" name="email" id="user-email-input">
                </div>
                <div class="row p-2">
                    <label class="col-md-2 col-sm-12" for="user-password-input">Password:</label>
                    <input class="col-md-5 col-sm-8" type="password" name="password" id="user-password-input">
                </div>
                <div class="row p-2">
                    <label class="col-md-4 col-sm-4 col-10" for="user-remember-input">Remember Me:</label>
                    <input class="col-md-1 col-sm-2 col-2" type="checkbox" name="remember_me" id="user-remember-input">
                </div>
                <div class="row p-2">
                    <div class="col-lg-1 col-md-2 col-sm-3 col-12 p-2 mx-1" >
                        <button class="btn" type="submit">Login</button>
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-3 col-12 p-2 mx-1">
                        <button class="btn" href="{{route('inicio.view')}}">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>

</html>