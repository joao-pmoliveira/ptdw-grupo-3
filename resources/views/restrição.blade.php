@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
            'crumbs' => [
                    ['página inicial', '/inicio'],
                    ['recolha', '/restricoes/submissao'],
                    ['restrição', '/restricao/'.$ano_inicial.'_'.$ano_final.'/'.$semestre.'/'.$id],
                ]
        ])
    
    <!-- @include('partials._pageTitle', ['title' => 'Restrições de UC '.$ano_inicial.'/'.$ano_final.' '.$semestre.'º Semestre - '.$id])
    <h1>Restrições de UC</h1> -->

    @include('partials._pageTitle', ['title' => 'Restrições de UC '.$ano_inicial.'/'.$ano_final.' '])
    <section class="mt-3">
        <form action="" method="post">
            <div class="class-sub-form-container">
                @include('partials._restrictionFormItem', ['class' => $classes[1]])<br>
            </div>
            <div class="d-flex gap-3 mb-5" id="form-btns">
                <input class="btn" type="button" value="Submeter">
                <input class="btn" type="button" value="Cancelar">
            </div>
            <br><br>
        </form>
    </section>
</main>

@endsection