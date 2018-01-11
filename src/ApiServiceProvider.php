<?php

namespace Yansongda\LaravelApi;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class PayServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(dirname(__DIR__).'/database/migrations');

        $this->loadRoutesFrom(dirname(__DIR__).'/routes/api.php');
        $this->loadRoutesFrom(dirname(__DIR__).'/routes/admin.php');

        $this->loadViewsFrom(dirname(__DIR__).'/resources/views', 'laravelApi');

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
        $this->mergeConfigFrom(dirname(__DIR__).'/config/api.php', 'api');

        $this->registerGuard();
    }

    /**
     * Publish resouces.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @return void
     */
    protected function publishResources()
    {
        $this->publishes([
            dirname(__DIR__).'/resources/views' => resource_path('views/vendor/api'),
        ], 'laravel-api-views');

        $this->publishes([
            dirname(__DIR__).'/database/migrations' => database_path('migrations')
        ], 'laravel-api-migrations');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                dirname(__DIR__).'/config/api.php' => config_path('api.php'), ],
                'laravel-api-config'
            );
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('api');
        }
    }

    protected function registerGuard()
    {
        Auth::extend('api', function ($app, $name, array $config) {
            // 返回一个 Illuminate\Contracts\Auth\Guard 实例...
        });
    }
}
