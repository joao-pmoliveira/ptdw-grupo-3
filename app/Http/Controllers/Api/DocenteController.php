<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocenteRequest;
use App\Models\Docente;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index() {}

    public function show(Docente $docente) {}

    public function store(DocenteRequest $docenteRequest) {}

    public function update(DocenteRequest $docenteRequest, Docente $docente) {}

    public function delete(Docente $docente) {}
}
