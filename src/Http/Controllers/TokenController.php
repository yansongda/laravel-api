<?php

namespace Yansongda\LaravelApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yansongda\LaravelApi\Api;
use Yansongda\LaravelApi\Exceptions\InvalidAppException;
use Yansongda\LaravelApi\Models\AccessToken;
use Yansongda\LaravelApi\Models\App;

class TokenController
{
    /**
     * Issue access_token.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     * @throws InvalidAppException
     * @throws \Yansongda\LaravelApi\Exceptions\GenerateAccessTokenException
     */
    public function issueToken(Request $request)
    {
        $app = App::where('app_id', $request->app_id)
                  ->where('app_secret', $request->app_secret)
                  ->first();

        if (is_null($app)) {
            throw new InvalidAppException('Invalid App Info');
        }

        $accessToken = AccessToken::updateOrCreate([
            'user_id' => $app->user_id,
            'app_id' => $app->app_id,
        ], [
            'access_token' => Api::generateAccessToken($app),
            'expired_at' => Carbon::now()->addSeconds(config('api.ttl', 7200))
        ]);

        return response()->json([
            'code' => 0,
            'message' => 'success',
            'data' => [
                'user_id' => $accessToken->user_id,
                'app_id' => $accessToken->app_id,
                'access_token' => $accessToken->access_token,
                'expired_in' => config('api.ttl', 7200),
            ],
        ]);
    }
}
