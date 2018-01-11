<?php

return [
    // access_token 有效时间，分
    'ttl' => '180',

    // refresh_token 有效时间，分
    'refresh_ttl' => '10080',

    // 用户 model
    'user' => App\Models\User::class,
];
