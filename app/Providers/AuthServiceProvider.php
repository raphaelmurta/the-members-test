<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * As políticas de mapeamento para a aplicação.
     *
     * @var array
     */
    protected $policies = [
        // Defina suas políticas de autorização aqui.
    ];

    /**
     * Registre quaisquer serviços de autenticação/ autorização.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Registre quaisquer Gates se necessário.
    }
}
