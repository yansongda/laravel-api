<?php

namespace Yansongda\LaravelApi;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Yansongda\LaravelApi\Guards\TokenGuard;

class ApiServiceProvider extends ServiceProvider
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
        $this->loadResources();

        $this->publishResources();
    }

    /**
     * Register the service.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @return void
     */
    public function register()
    {
        $this->registerGuard();

        $this->detectUserProvider();
    }

    /**
     * Load resources.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return void
     */
    protected function loadResources()
    {
        $this->loadMigrationsFrom(dirname(__DIR__) . '/database/migrations');

        if (Api::$enableRoute) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/api.php');
        }
    }

    /**
     * Publish resources.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @return void
     */
    protected function publishResources()
    {
        $this->publishes([
            dirname(__DIR__) . '/database/migrations' => database_path('migrations')
        ], 'laravel-api-migrations');
    }

    /**
     * Register guard.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return void
     */
    protected function registerGuard()
    {
        Auth::extend('api', function ($app, $name, array $config) {
            $guard = new TokenGuard($app['request']);

            $user = $guard->user();

            $app['request']['user'] = $user->{$user->getKeyName()};
            $app['request']['app'] = $guard->app()->app_id;

            return $guard;
        });
    }

    /**
     * Detect user provider.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return void
     */
    protected function detectUserProvider()
    {
        $provider = config('auth.guards.api.provider');

        Api::$user = config('auth.providers.' . $provider . '.model');
    }
}
