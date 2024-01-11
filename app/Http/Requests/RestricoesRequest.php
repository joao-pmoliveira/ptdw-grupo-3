<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestricoesRequest extends FormRequest
{
    /**
     * Autoriza apenas se o utilizador for admin
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'obligatory_labs' => '',
            'needed_software' => '',
            'evaluation_labs' => '',
        ];
    }
}
