<?php

namespace CatchClient;

use Illuminate\Support\ServiceProvider;

class CatchServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/catch.php' => config_path('catch.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind('deferdie-CatchClient', function(){
            return new Logger();
        });
    }
}