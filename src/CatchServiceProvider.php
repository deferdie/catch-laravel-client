<?php

namespace CatchClient;

use Illuminate\Support\ServiceProvider;

class CatchServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind('deferdie-CatchClient', function(){
            return new Logger();
        });
    }
}