<?php

use Yansongda\LaravelApi\Api;

Route::prefix(Api::$routePrefix)->namespace('Yansongda\LaravelApi\Http\Controllers')->group(function () {
    Route::post('token', 'TokenController@issueToken');
});
