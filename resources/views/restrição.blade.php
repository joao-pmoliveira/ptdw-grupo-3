@extends('layouts.baseContent')

@section('main')

<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
            'crumbs' => [
                    ['página inicial', route('inicio.view')],
                    ['preencher restrições', route('restricoes.view')],
                    ['restrições de '.strtolower($uc->nome), route('restricoes.uc.view', [
                        'uc' => $uc->id,
                        'ano_inicial' => $ano_inicial,
                        'semestre' => $semestre])]
                ]
        ])

    @include('partials._pageTitle', ['title' => 'Restrições de '. $uc->nome. ' - '.$ano_inicial.'/'. ($ano_inicial+1).' '])
    <section class="mt-3">
        <form action="" method="post">
            <div class="class-sub-form-container">
                @include('partials._restrictionFormItem', ['uc' => $uc])
            </div>
            <div class="d-flex gap-3 mb-5" id="form-btns">
                <input class="btn" type="button" value="Submeter">
                <input class="btn" type="button" value="Cancelar">
            </div>
        </form>
    </section>
</main>

@auth
    <script>
        const authUser = @json(auth()->user());
    </script>
@endauth
<script src="{{asset('js/restricao.js')}}" defer></script>
@endsection