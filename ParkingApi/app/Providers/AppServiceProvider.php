<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interface\IPdf;
use App\Service\Pdf;
use App\Services\Facturacion\ProveedorInterface;
use App\Services\Facturacion\MockProveedor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IPdf::class, Pdf::class);
        $this->app->bind(ProveedorInterface::class, function ($app) {
            // Aquí podrías usar lógica para decidir qué proveedor usar
            return new MockProveedor();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}