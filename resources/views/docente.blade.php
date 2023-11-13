@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
                ['página inicial', '/inicio'],
                ['gerir dados', '/gerir']
            ]
    ])

    @include('partials._pageTitle', ['title' => 'Docente'])

   
    <section class = "mt-5" >
        <form action="" method="post" class="title-separator"></form>
            <div class="d-flex gap-5 aling-items-center px-2 py-2">
                <label for="nMec" class="my-auto">Nº Mec. :</label>  
                <input type="text" id="nMec" value="110420" class="px-1 py-1">
                <label for="nome" class="my-auto">Nome :</label>  
                <input type="text" id="nMec" value="José Silva" class="px-1 py-1 col-2 col-sm-3 col-md-4 col-lg-6 col-xl-7">
            </div>
            <div class="d-flex gap-5 aling-items-center border border-dark px-2 py-3 mt-4">
                <label for="email" class="my-auto">Email :</label>  
                <input type="text" id="email" value="josesilva@ua.pt" class="px-1 py-1">
            </div>
            <div class="d-flex gap-3">
                <input class="btn" type="button" value="Confirmar">
                <input class="btn" type="button" value="Remover">
                <input class="btn" type="button" value="Cancelar">
            </div>
        </form>
    </section>



    </main>
@endsection
