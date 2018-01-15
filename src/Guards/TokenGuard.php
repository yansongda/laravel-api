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
        $token = $this->parseAccessToken();

        $accessToken = $this->findAccessToken($token);

        return $this->user = $accessToken->user;
    }

    /**
     * Validate the accessToken.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param array $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        if ($this->findAccessToken($credentials['access_token'])) {
            return true;
        }

        return false;
    }

    /**
     * Get access_token.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return string
     */
    protected function parseAccessToken()
    {
        $token = $this->request->query($this->inputKey);

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        if (empty($token)) {
            $token = $this->request->getPassword();
        }

        if (empty($token)) {
            throw new AccessTokenNotProvidedException("AccessToken Is Not Provided", 1);
        }

        return $token;
    }

    /**
     * Find accessToken.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $token
     *
     * @return AccessToken
     */
    protected function findAccessToken($token)
    {
        if (is_null($accessToken = AccessToken::where('access_token', $token)->first())) {
            throw new InvalidAccessTokenException('AccessToken Is Invalid', 2);
        }

        if (Carbon::now()->gte($accessToken->expired_at)) {
            throw new AccessTokenExpiredException(
                'AccessToken Is Expired', 3,
                ['now' => Carbon::now(), 'expired' => $accessToken->expired_at]
            );
        }

        return $accessToken;
    }
}
