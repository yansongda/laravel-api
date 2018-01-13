<?php

namespace Yansongda\LaravelApi\Models;

use Illuminate\Database\Eloquent\Model;
use Yansongda\LaravelApi\Api;

class AccessToken extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_access_tokens';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['expired_at'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app()
    {
        $this->belongsTo(App::class, 'app_id', 'id');
    }
}
