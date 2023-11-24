@extends('layouts.baseContent')

@section('main')
<main class="w-100 px-5">
    @include('partials._breadcrumbs', [
        'crumbs' => [
            ['página inicial', '/inicio'],
            ['gerir dados', '/gerirdados']
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
                    Importar Serviço-Docente
                </button>
            </li>
        </ul>
    </section>
    <div class="tab-content pt-3">
        <section id="manage-ucs" class="tab-pane active">
            <div class="d-flex flex-column gap-3">
              

                <div class="d-flex justify-content-between mb-3 flex-wrap">
                    <div class="d-flex gap-3 justify-content-stretch">
                        <select name="school_year_semester" id="school-year-semester" aria-label="Filtre por ano e semestre">
                            <option value="2023_2024_2">2023/24 2ºSemestre</option>
                            <option value="2023_2024_1">2023/24 1ºSemestre</option>
                            <option value="2022_2023_2">2022/23 2ºSemestre</option>
                            <option value="2022_2023_1">2022/23 1ºSemestre</option>
                            <option value="2021_2022_2">2021/22 2ºSemestre</option>
                            <option value="2021_2022_1">2021/22 1ºSemestre</option>
                        </select>
                        <select name="school_course" id="school-year-school_course" aria-label="Filtre por curso">
                            <option value="" selected>Filtre Por Curso</option>
                            <option value="ti">TI</option>
                            <option value="gc">GC</option>
                        </select>
                        <div class="paco-searchbox">
                            <input type="text" name="nome_cod_uc" id="" aria-label="Filtre por código ou nome de uc">
                            <div><i class="fa-solid fa-search"></i></div>
                        </div>
                    </div>
                    <div>
                        <button class="btn">Adicionar UC</button>
                    </div>
                </div>
                
                <table class="title-separator" id="table-edit-ucs">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col-1">Cód.</th>
                            <th scope="col-5">Nome</th>
                            <th scope="col-3">Docente Responsável</th>
                            <th scope="col-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id='91998'>
                            <th scope="row"></th>
                            <td>91998</td>
                            <td>Matemática Aplicada às Tecnologias de Informação</td>
                            <td>Luísa Mendes</td>
                            <td><i class="fa-solid fa-pen"></i></td>
                        </tr>
                        <tr data-id="88765">
                            <th scope="row"></th>
                            <td>88765</td>
                            <td>Web Design</td>
                            <td>Rita Gonçalves</td>
                            <td><i class="fa-solid fa-pen"></i></td>
                        </tr>
                        <tr data-id='85095'>
                            <th scope="row"></th>
                            <td>85095</td>
                            <td>Inteligência Artificial</td>
                            <td>José Silva</td>
                            <td><i class="fa-solid fa-pen"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="manage-teachers" class="tab-pane">
            <div class="d-flex flex-column gap-3">    
               
                <div class="d-flex justify-content-between mb-3 flex-wrap">
                    <div class="paco-searchbox">
                        <input type="text" name="teacher_identifier" id="teacher-identifier" placeholder="NºMecanográfico ou Nome" aria-label="Filtre por número mecanográfico ou nome do docente">
                        <div><i class="fa-solid fa-search"></i></div>
                        
                    </div>
                    <div >
                        <button class="btn">Adicionar Docente</button>
                    </div>
                    
                </div>
                <table class="title-separator" id="table-edit-teachers">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nº</th>
                            <th scope="col">Nome</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody >
                        <tr data-id='110555'>
                            <th scope="row"></th>
                            <td>110555</td>
                            <td>José Silva</td>
                            <td><i class="fa-solid fa-pen"></i></td>
                        </tr>
                        <tr data-id='123456'>
                            <th scope="row"></th>
                            <td>123456</td>
                            <td>Luísa Mendes</td>
                            <td><i class="fa-solid fa-pen"></i></td>
                        </tr>
                        <tr data-id="333555">
                            <th scope="row"></th>
                            <td>333555</td>
                            <td>Rita Gonçalves</td>
                            <td><i class="fa-solid fa-pen"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="import-data" class="tab-pane">
            <div class="d-flex flex-column gap-3">
                <div class="d-flex gap-2 align-items-center">
                    <label for="import-file-input">Selecione um ficheiro</label><br>
                    <input type="file" name="uc-data-file" id="import-file-input">
                </div>
                <div class="d-flex gap-3">
                    <input class="btn" type="button" value="Submeter">
                </div>
            </div>
        </section>
    </div>
    
</main>

@endsection