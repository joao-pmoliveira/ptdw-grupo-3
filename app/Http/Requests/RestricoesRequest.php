<?php

namespace App\Http\Requests;

use App\Models\UnidadeCurricular;
use Illuminate\Foundation\Http\FormRequest;

class RestricoesRequest extends FormRequest
{
    /**
     * Autoriza apenas se o utilizador for admin
     */
    public function authorize(): bool
    {
        $uc = UnidadeCurricular::findOrFail($this->route('id'));

        $user = $this->user();

        return !is_null($user) && !is_null($uc) && $user->docente->id == $uc->docenteResponsavel->id;
    }


    public function rules(): array
    {
        return [
            'aula_laboratorio' => 'nullable',
            'exame_final_laboratorio' => 'nullable',
            'exame_recurso_laboratorio' => 'nullable',
            'observacoes' => 'nullable|string',
            'software' => 'nullable|string',
        ];
    }
}
