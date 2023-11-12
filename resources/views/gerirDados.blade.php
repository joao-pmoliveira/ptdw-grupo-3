@extends('layouts.baseContent')

@section('main')
<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
            ['página inicial', '/'],
            ['gerir dados', '/manage']
        ]
    ])
    
    @include('partials._pageTitle', ['title' => 'Gerir Dados'])

    <section class="mt-5">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle='tab' data-bs-target='#manage-ucs'>
                    Gerir Unidades Curriculares
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle='tab' data-bs-target='#manage-teachers'>
                    Gerir Docentes
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle='tab' data-bs-target='#import-data'>
                    Importar Dados
                </button>
            </li>
        </ul>
    </section>
.
    <div class="tab-content">
        <section id="manage-ucs" class="tab-pane active">
            <!--Gerir Unidades Curriculares-->
        </section>
        <section id="manage-teachers" class="tab-pane">
            <!--Gerir Docentes-->
        </section>
        <section id="import-data" class="tab-pane">
            <div class="d-flex flex-column gap-3">
                <h2 >Importar dados das Unidades Curriculares</h2>
                <div class="d-flex gap-2 align-items-center">
                    <label for="import-file-input">Selecione um ficheiro</label><br>
                    <input type="file" name="uc-data-file" id="import-file-input">
                </div>
                <div class="d-flex gap-3">
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
            </div>
        </section>
    </div>
    
</main>

@endsection