<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadeCurricularRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codigo' => 'required|integer',
            'sigla' => 'required|string',
            'periodo_id' => 'required|exists:periodos,id',
            'nome' => 'required|string',
            'acn_id' => 'required|exists:acns,id',
            'horas_semanais' => 'required|integer',
            'laboratorio' => 'required|boolean',
            'software' => 'nullable|string',
            'ects' => 'required|integer',
            'sala_avaliacao' => 'required|boolean',
            'docente_responsavel_id' => 'required|exists:docentes,id',
        ];
    }
}
