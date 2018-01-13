<?php

namespace Yansongda\LaravelApi\Models;

use Illuminate\Database\Eloquent\Model;
use Yansongda\LaravelApi\Api;

class App extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_apps';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['app_secret'];

    /**
     * Get the user that the token belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Api::$user);
    }

    /**
     * Get the app that the token belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function token()
    {
        $this->hasOne(AccessToken::class, 'app_id', 'id');
    }
}
