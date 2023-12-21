<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'acn_id' => 'required|exists:acns,id',
            'email' => 'required|email|unique:docentes,email',
            'numero_telefone' => 'nullable|regex:/^[0-9+\s]+$/'
        ];
    }
}
