<?php

namespace App\Http\Controllers;

use App\Models\UnidadeCurricular;
use Illuminate\Http\Request;

class UnidadeCurricularViewController extends Controller
{
    public function unidadesCurriculares() {
        return view('unidadesCurriculares', [
            'page_title' => 'Consultar Unidades Curriculares'
        ]);
    }

    public function unidadeCurricular(UnidadeCurricular $uc) {
        return view('unidadeCurricular', [
            'page_title' => 'Unidade Curricular',
            'uc' => $uc
        ]);
    }

    public function editarUnidadeCurricular(UnidadeCurricular $uc) {
        return view('editarUnidadeCurricular', [
            'page_title' => 'Unidade Curricular',
            'uc' => $uc
        ]);
    }
}
