<?php

namespace Yansongda\LaravelApi;

class Api
{
    /**
     * User model.
     *
     * @var [type]
     */
    public static $user;

    /**
     * Set user model
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $app
     */
    public static function setUserModelEnvironment($app = 'lumen')
    {
        switch ($app) {
            case 'laravel':
                $provider = config('auth.guards.api.provider');
                self::$user = config('auth.providers.'.$provider.'.model');
                break;
            
            default:
                self::$user = config('api.user');
                break;
        }

        return self::$user;
    }
}
