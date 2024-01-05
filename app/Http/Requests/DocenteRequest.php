<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DocenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('admin-access', $this->user());
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'acn' => 'required|exists:acns,id',
            'email' => 'required|email|unique:docentes,email',
            'telemovel' => 'nullable|regex:/^[0-9+\s]+$/',
            'numero' => 'required|integer|min:1',
        ];
    }
}
