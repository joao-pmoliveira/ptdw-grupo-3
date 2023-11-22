@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
            'crumbs' => [
                    ['página inicial', '/inicio'],
                    ['restrições', '/restricoes'],
                    ['restrição', '/restricao/'.$ano_inicial.'_'.$ano_final.'/'.$semestre.'/'.$id],
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
                <input class="btn" type="button" value="Submeter">
                <input class="btn" type="button" value="Cancelar">
            </div>
        </form>
    </section>
</main>

@endsection