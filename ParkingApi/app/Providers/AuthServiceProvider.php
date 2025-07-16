<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        App\Models\Transaccion::class => App\Policies\TransaccionPolicy::class,
        App\Models\Vehiculo::class => App\Policies\VehiculoPolicy::class,
        App\Models\Cliente::class => App\Policies\ClientePolicy::class,
        App\Models\Cargo::class => App\Policies\CargoPolicy::class,
        App\Models\Tarifa::class => App\Policies\TarifaPolicy::class,
        App\Models\User::class => App\Policies\UserPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
