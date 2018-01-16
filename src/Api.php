<?php

namespace Yansongda\LaravelApi;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Str;
use Yansongda\LaravelApi\Exceptions\CreateAppException;
use Yansongda\LaravelApi\Exceptions\GenerateAccessTokenException;
use Yansongda\LaravelApi\Models\App;

class Api
{
    /**
     * User model.
     *
     * @var UserProvider
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

        return md5(uniqid('access_token', true).$app->user_id.$app->app_id.$app->app_secret);
    }

    /**
     * Create app.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param UserProvider $user
     * @param string|null  $others
     *
     * @return App
     */
    public static function createApp($user, $others = null)
    {
        if (! $user instanceof UserProvider) {
            throw new CreateAppException('['.get_class($user)."] Must Be An Instance Of [Illuminate\Contracts\Auth\UserProvider]");
        }

        return App::create([
            'user_id' => $user->{$user->getKeyName},
            'app_id' => md5(uniqid('app_id', true).$user->{$user->getKeyName}),
            'app_secret' => md5(Str::random(32)),
            'others' => $others,
        ]);
    }
}
