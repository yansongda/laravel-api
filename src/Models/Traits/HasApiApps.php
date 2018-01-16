<?php

namespace Yansongda\LaravelApi\Models\Traits;

use Yansongda\LaravelApi\Models\AccessToken;
use Yansongda\LaravelApi\Models\App;

trait HasApiApps
{
    /**
     * Get all of the user's registered apps.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function apps()
    {
        return $this->hasMany(App::class, 'user_id');
    }

    /**
     * Get all of the access tokens for the user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function tokens()
    {
        return $this->hasMany(AccessToken::class, 'user_id');
    }
}
