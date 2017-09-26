<?php

namespace Santiagotoledo91\SimpleSOAP;

use Illuminate\Support\ServiceProvider;

class SimpleSOAPServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/../config/simplesoap.php' => config_path('simplesoap.php'),
        ]);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('simplesoap', function () {
            return new SimpleSOAP();
        });

    }
}
