<?php

namespace Yansongda\LaravelApi;

use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class Api
{
    /**
     * User model.
     *
     * @var \Illuminate\Contracts\Auth\UserProvider
     */
    public static $user;

    /**
     * Determin user provider.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param LaravelApplication|LumenApplication $app
     *
     * @return void
     */
    public static function determinUserProvider($app)
    {
        if ($app instanceof LaravelApplication) {
            $provider = config('auth.guards.api.provider');
            self::$user = config('auth.providers.'.$provider.'.model');
        }

        if ($app instanceof LumenApplication) {
            self::$user = config('api.user');
        }
    }
}
