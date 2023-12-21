<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnidadeCurricularRequest;
use App\Models\UnidadeCurricular;
use Illuminate\Http\Request;

class UnidadeCurricularController extends Controller
{
    public function index() {}

    public function show(UnidadeCurricular $uc) {}

    public function store(UnidadeCurricularRequest $ucRequest) {}

    public function update(UnidadeCurricularRequest $ucRequest, UnidadeCurricular $uc) {}

    public function delete(UnidadeCurricular $uc) {}
}
