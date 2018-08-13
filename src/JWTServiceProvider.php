<?php

namespace empratur256\JWT;

use empratur256\JWT\commands\MigrationCommand;
use empratur256\JWT\Middleware\JWTMiddleware;
use Illuminate\Support\ServiceProvider;


class JWTServiceProvider extends ServiceProvider
{


    protected $defer = true;


    public function boot()
    {
        $this->commands('command.JWT.migration');

    }

    public function register()
    {
     $this->registerJWT();

     $this->registerMigrationCommand();
    }

    public function provides()
    {
        return ['src'];
    }


    private function registerJWT()
    {
        $this->app->bind('JWT', function ($app) {
            return new JWTMiddleware();
        });
    }

    private function registerMigrationCommand()
    {
        $this->app->singleton('command.JWT.migration', function ($app) {
            return new MigrationCommand();
        });
    }
}
