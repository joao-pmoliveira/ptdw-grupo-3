<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Impedimento;
use App\Policies\ImpedimentoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Impedimento::class => ImpedimentoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin-access', fn ($user) => $user->admin);

        Gate::define('acess-docente-impedimentos', function ($user, $docentePermitido) {
            return $user->docente && $user->docente->id == $docentePermitido->id;
        });

        Gate::define('access-uc-restricoes', function ($user, $unidadeCurricular) {
            return $user->docente && $unidadeCurricular->docentes->contains($user->docente);
        });
    }
}
