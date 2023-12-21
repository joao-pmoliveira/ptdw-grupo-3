<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImpedimentoRequest extends FormRequest
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
            'periodo_id' => 'required|exists:periodos,id',
            'docente_id' => 'required|exists:docentes,id',
            'impedimentos' => 'required|string',
            'justificacao' => 'nullable|string',
        ];
    }
}
