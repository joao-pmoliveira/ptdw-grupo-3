@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
            'crumbs' => [
                    ['página inicial', '/inicio'],
                    ['restrições', '/restrições']
                ]
        ])
    
    @include('partials._pageTitle', ['title' => 'Restrições de sala '.$ano_inicial.'/'.$ano_final.' '.$semestre.'º Semestre - '.$id])

    <section class="mt-5">
        <form action="" method="post">
            <h2 class="mb-3">Docente Responsável em:</h2>
            <div class="class-sub-form-container">
                @foreach($classes as $class)
                    @include('partials._restrictionFormItem', ['class' => $class])
                @endforeach
            </div>
            <div class="d-flex gap-3 mb-5" id="form-btns">
                <input class="d-block
                    m-0 py-2 px-3
                    btn btn-primary rounded-0
                    border border-primary
                    btn-outline-0
                    shadow-none
                    text-primary button-txt
                    text-capitalize" type="button" value="Submeter">
                <input class="d-block
                    m-0 py-2 px-3
                    btn btn-primary rounded-0
                    border border-primary
                    btn-outline-0
                    shadow-none
                    text-primary button-txt
                    text-capitalize" type="button" value="Cancelar">
            </div>
        </form>
    </section>
</main>

@endsection