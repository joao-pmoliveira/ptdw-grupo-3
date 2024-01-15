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
            'nome' => 'required|string',
            'acn' => 'required|integer|exists:acns,id',
            'email' => 'required|email',
            'telemovel' => 'required|integer',
            'numero' => 'required|integer|min:1',
        ];
    }
}
