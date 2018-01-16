<?php

namespace Yansongda\LaravelApi;

use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;
use Yansongda\LaravelApi\Exceptions\GenerateAccessTokenException;
use Yansongda\LaravelApi\Models\App;

class Api
{
    /**
     * User model.
     *
     * @var \Illuminate\Contracts\Auth\UserProvider
     */
    public static $user;

    /**
     * Route prefix.
     *
     * @var string
     */
    public static $routePrefix = 'api';

    /**
     * Set route prefix.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $prefix
     *
     * @return void
     */
    public static function setRoutePrefix($prefix = '')
    {
        self::$routePrefix = $prefix;
    }

    /**
     * Generate access_token.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param App $app
     *
     * @return string
     */
    public static function generateAccessToken($app)
    {
        if (! $app instanceof App) {
            throw new GenerateAccessTokenException('['.get_class($app).'] Must Be An Instance Of [Yansongda\LaravelApi\Models\App]');
        }

        return md5(uniqid('access_token', true).$app->app_id.$app->user_id);
    }
}
