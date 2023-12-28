@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
            ['página inicial', route('inicio.view')],
            ['gerir dados', route('admin.gerir.view')]
        ]
    ])

    @include('partials._pageTitle', ['title' => $docente->nome])


    <section class="mt-3">
        <form action="" method="post" class="title-separator"></form>
        <br>
        <div class="row">
            <div class="col-sm-12 col-md-2 col-lg-2">
                <label for="nMec" class="my-auto">Nº Mec. :</label>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <input type="text" id="nMec" value="{{$docente->numero_funcionario}}" class="px-1 py-1">
            </div>

            

            <div class="col-sm-12 col-md-2 col-lg-1">
                <label for="nome" class="my-auto">Nome :</label>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-2">
                <input type="text" id="nMec" value="{{$docente->nome}}" class="px-1 py-1">
            </div>

            
        </div>
        <br>
        <div class="border border-dark">
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-2 col-lg-2 d-flex gap-5 aling-items-center">
                    <label for="email" class="my-auto">Email :</label>
                </div>
                <div class="col-sm-12 col-md-10 col-lg-10 d-flex gap-5 aling-items-center"> 
                    <!-- todo aumentar largura input email -->
                    <input type="text" id="email" value="{{$docente->email}}" class="px-1 py-1">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-2 col-lg-2 d-flex gap-5 aling-items-center">
                    <label for="phonenumber" class="my-auto">Nº Telemóvel :</label>
                </div>
                <div class="col-sm-12 col-md-10 col-lg-10 d-flex gap-5 aling-items-center">
                    <input type="number" id="phonenumber" value="{{$docente->numero_telefone}}" maxlength="9" minlength="9"
                        class="px-1 py-1">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-2 col-lg-2 d-flex gap-5 aling-items-center">
                    <label for="acn" class="my-auto">Área Cientifica Nuclear :</label>
                </div>
                <div class="col-sm-12 col-md-10 col-lg-10 d-flex gap-5 aling-items-center">
                    <input type="text" id="acn" value="{{$docente->acn->sigla}}" class="px-1 py-1">
                </div>
            </div>
            <br>
        </div>
        <br>
        <div class="d-flex gap-3">
            <input class="btn" type="button" value="Confirmar">
            <input class="btn" type="button" value="Remover">
            <input class="btn" type="button" value="Cancelar">
        </div>
        </form>
    </section>
</main>
@endsection