<?php

namespace  Yansongda\LaravelApi\Guards;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yansongda\LaravelApi\Exceptions\AccessTokenExpiredException;
use Yansongda\LaravelApi\Exceptions\AccessTokenNotProvidedException;
use Yansongda\LaravelApi\Exceptions\InvalidAccessTokenException;
use Yansongda\LaravelApi\Models\AccessToken;
use Yansongda\LaravelApi\Models\App;

class TokenGuard implements Guard
{
    use GuardHelpers;

    /**
     * The request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * The app.
     *
     * @var App
     */
    protected $app;

    /**
     * The name of the query string item from the request containing the API token.
     *
     * @var string
     */
    protected $inputKey;

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->inputKey = 'access_token';
    }

    /**
     * Get the currently authenticated user.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (! is_null($this->user)) {
            return $this->user;
        }

        $accessToken = $this->parseAccessToken();

        return $this->user = $accessToken->user;
    }

    /**
     * Get the currently app.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return App
     */
    public function app()
    {
        if (! is_null($this->app)) {
            return $this->app;
        }

        $accessToken = $this->parseAccessToken();

        return $this->app = $accessToken->app;
    }

    /**
     * Validate the accessToken.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param array $credentials
     *
     * @return bool
     * @throws AccessTokenExpiredException
     * @throws InvalidAccessTokenException
     */
    public function validate(array $credentials = [])
    {
        if ($this->queryAccessToken($credentials['access_token'])) {
            return true;
        }

        return false;
    }

    /**
     * Parse accessToken.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return AccessToken
     * @throws AccessTokenExpiredException
     * @throws AccessTokenNotProvidedException
     * @throws InvalidAccessTokenException
     */
    protected function parseAccessToken()
    {
        $token = $this->findAccessToken();

        return $this->queryAccessToken($token);
    }

    /**
     * Get access_token.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return string
     * @throws AccessTokenNotProvidedException
     */
    protected function findAccessToken()
    {
        $token = $this->request->query($this->inputKey);

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        if (empty($token)) {
            $token = $this->request->getPassword();
        }

        if (! empty($token)) {
            return $token;
        }

        throw new AccessTokenNotProvidedException('AccessToken Is Not Provided');
    }

    /**
     * Query accessToken.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $token
     *
     * @return AccessToken
     * @throws AccessTokenExpiredException
     * @throws InvalidAccessTokenException
     */
    protected function queryAccessToken($token)
    {
        if (is_null($accessToken = AccessToken::where('access_token', $token)->first())) {
            throw new InvalidAccessTokenException('AccessToken Is Invalid');
        }

        if (Carbon::now()->lte($accessToken->expired_at)) {
            return $accessToken;
        }

        throw new AccessTokenExpiredException(
            'AccessToken Is Expired',
            ['now' => Carbon::now(), 'expired' => $accessToken->expired_at]
        );
    }
}
