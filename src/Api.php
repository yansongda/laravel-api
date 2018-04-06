<?php

namespace Yansongda\LaravelApi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Yansongda\LaravelApi\Exceptions\CreateAppException;
use Yansongda\LaravelApi\Exceptions\GenerateAccessTokenException;
use Yansongda\LaravelApi\Models\AccessToken;
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
     * AccessToken expired after.
     *
     * @var int
     */
    public static $ttl = 7200;

    /**
     * Is enable route.
     *
     * @var bool
     */
    public static $enableRoute = false;

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
     * Enable route.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param bool $status
     *
     * @return void
     */
    public static function enableRoute($status = true)
    {
        self::$enableRoute = $status;
    }

    /**
     * Generate access_token.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param App $app
     *
     * @return string
     * @throws GenerateAccessTokenException
     */
    public static function generateAccessToken($app)
    {
        if (! ($app instanceof App)) {
            throw new GenerateAccessTokenException('[' . get_class($app) . '] Must Be An Instance Of [Yansongda\LaravelApi\Models\App]');
        }

        dd(strval($app->app_id));

        return AccessToken::updateOrCreate([
            'user_id' => $app->user_id,
            'app_id' => $app->app_id,
        ], [
            'access_token' => md5(uniqid('access_token', true) . $app->user_id . $app->app_id . $app->app_secret),
            'expired_at' => Carbon::now()->addSeconds(self::$ttl)
        ]);
    }

    /**
     * Create app.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param Model $user
     * @param string|null $others
     *
     * @return App
     * @throws CreateAppException
     */
    public static function createApp($user, $others = null)
    {
        if (!$user instanceof Model) {
            throw new CreateAppException('[' . get_class($user) . '] Must Be An Instance Of [Illuminate\Database\Eloquent\Model]');
        }

        return App::create([
            'user_id' => $user->{$user->getKeyName()},
            'app_id' => md5(uniqid('app_id', true) . $user->{$user->getKeyName()}),
            'app_secret' => md5(Str::random(32)),
            'others' => $others,
        ]);
    }
}
