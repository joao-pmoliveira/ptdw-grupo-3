<?php

namespace App\Policies;

use App\Models\Impedimento;
use App\Models\User;

class ImpedimentoPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function updateImpedimento(User $user, Impedimento $impedimento)
    {
        return $user->docente && $impedimento->docente->id === $user->docente->id;
    }
}
