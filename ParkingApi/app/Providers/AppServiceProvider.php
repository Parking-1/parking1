<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interface\IPdf;
use App\Service\Pdf;

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
