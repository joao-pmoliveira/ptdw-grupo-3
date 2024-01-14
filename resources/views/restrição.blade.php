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

    @include('partials._pageTitle', ['title' => 'Restrições de '. $uc->nome. ' - '.$ano_inicial.'/'. ($ano_inicial+1).' - '.$semestre.'º Semestre'])

    <section class="mt-3">
        <form action="{{route('restricoes.update', ['id' => $uc->id])}}"  method="POST" id="restricao-form">
            @csrf
            @method('PUT')
            <div class="title-separator d-flex flex-column gap-3 py-4">
                <fieldset class="">
                    <legend>Tipo de Sala</legend>
                    <div class="d-flex gap-3 px-3 lab-requirement-type-container flex-wrap">
                        <div class="paco-checkbox">
                            <label class="form-check-label" for="obligatory-labs">Sala Comum</label>
                            <div class="form-check form-switch d-flex align-items-center mx-2 gap-2">
                                <input class="form-check-input" 
                                    name="obligatory_labs" id="obligatory-labs" type="checkbox" @checked($uc->laboratorio) 
                                    role="switch" @disabled(!$editavel)>
                                <label class="form-check-label" for="obligatory-labs">Laboratório de Informática</label>
                            </div>
                        </div>
                    </div>
                </fieldset>
            
                <fieldset>
                    <legend>Software necessário</legend>
                    <p>Identifique nome, fabricante, versão, e sistema operativo</p>
                    <label for="needed-soft"></label>
                    <textarea class="mx-3 px-2 py-1" name="needed_software" id="needed-soft" @disabled(!$editavel)
                        cols="100" rows="7">{{$uc->software}}</textarea>
                </fieldset>
            
                <fieldset class=" px3">
                    <legend>Tipo de sala para avaliações</legend>
                    <div class="d-flex gap-3 px-3 lab-requirement-type-container flex-wrap">
                        <div class="paco-checkbox">
                            <label class="form-check-label" for="evaluation-labs">Sala Comum</label>
                            <div class="form-check form-switch d-flex align-items-center mx-2 gap-2">
                                <input class="form-check-input"
                                    name="evaluation_labs" id="evaluation-labs" type="checkbox" @checked($uc->sala_avaliacao)
                                    role="switch" @disabled(!$editavel)>
                                <label class="form-check-label" for="evaluation-labs">Laboratório de Informática</label>
                            </div>
                        </div>
                    </div>
                </fieldset> 
            </div>
            <div class="d-flex gap-3 mb-5" id="form-btns">
                <input class="btn" type="submit" value="Submeter" @disabled(!$editavel)>
                <a class="btn" href="{{route('restricoes.view')}}" value="Cancelar">Cancelar</a>
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