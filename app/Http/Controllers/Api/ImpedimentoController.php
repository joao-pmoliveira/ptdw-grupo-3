<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImpedimentoRequest;
use App\Models\Impedimento;
use Illuminate\Http\Request;

class ImpedimentoController extends Controller
{
    public function index() {}

    public function show(Impedimento $impedimento) {}

    public function store(ImpedimentoRequest $impedimentoRequest) {}

    public function update(ImpedimentoRequest $impedimentoRequest, Impedimento $impedimento) {}

    public function delete(Impedimento $impedimento) {}
}
