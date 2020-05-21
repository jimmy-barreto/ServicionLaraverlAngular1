<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('administrar-usuarios', function($user) {
            return $user->hasAnyRol(['admin','desarrollador']);
        });

        Gate::define('editar-usuario', function($user) {
            return $user->hasAnyRol(['admin','desarrollador']);
        });

        Gate::define('eliminar-usuario', function($user) {
            return $user->hasRol('admin');
        });



        Gate::define('admin-proyecto', function($user) {
            return $user->hasAnyRol(['admin','desarrollador']);
        });

        Gate::define('crear-proyecto', function($user) {
            return $user->hasRol('admin');
        });
        
        Gate::define('editar-desarrollador', function($user) {
            return $user->hasAnyRol(['admin','desarrollador']);
        });

        Gate::define('editar-proyecto', function($user) {
            return $user->hasRol('admin');
        });
        
        Gate::define('eliminar-proyecto', function($user) {
            return $user->hasRol('admin');
        });

        Gate::define('eliminar-desarrollador', function($user) {
            return $user->hasRol('admin');
        });

    }
}
