<?php

namespace App\Policies;

use App\Models\UnidadeCurricular;
use App\Models\User;

class UnidadeCurricularPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function updateRestricoes(User $user, UnidadeCurricular $uc)
    {
        return $user->docente &&
            $uc->docenteResponsavel &&
            $user->docente->id === $uc->docenteResponsavel->id;
    }
}
