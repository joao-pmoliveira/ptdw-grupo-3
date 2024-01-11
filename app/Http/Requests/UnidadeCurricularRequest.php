<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UnidadeCurricularRequest extends FormRequest
{
    /**
     * Autoriza apenas se o utilizador for admin
     */
    public function authorize(): bool
    {
       return Gate::allows('admin-access', $this->user());
    }


    public function rules(): array
    {
        return [
            'codigo' => 'required|integer|min:1',
            'nome' => 'required|string',
            'horas' => 'required|integer|min:1',
            'ects' => 'required|integer|min:0',
            'acn' => 'required|integer|exists:acns,id',
            'docente_responsavel_id' => 'required|integer|exists:docentes,id',
            'docentes_id' => 'array',
        ];
    }
}
