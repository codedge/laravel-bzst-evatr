<?php

namespace Codedge\Evatr;

use Illuminate\Support\ServiceProvider;

class EvatrServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'evatr');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/evatr'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('evatr', function ($app) {
            return new Evatr();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['evatr'];
    }
}
