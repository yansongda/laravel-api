<?php

namespace Yansongda\LaravelApi;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class PayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(dirname(__DIR__).'/migrations');

        $this->loadRoutesFrom(dirname(__DIR__).'/routes/api.php');
        $this->loadRoutesFrom(dirname(__DIR__).'/routes/admin.php');

        $this->loadViewsFrom(dirname(__DIR__).'/views', 'laravelApi');

        $this->publishResources();
    }

    /**
     * Registe the service.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @return void
     */
    public function register()
    {
        # code...
    }

    /**
     * Publish resouces.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @return void
     */
    public function publishResources()
    {
        $this->publishes([
            dirname(__DIR__).'/views' => resource_path('views/vendor/api'),
        ], 'laravel-api-config');

        $this->publishes([
            dirname(__DIR__).'/migrations' => database_path('migrations')
        ], 'laravel-api-migrations');
    }
}
