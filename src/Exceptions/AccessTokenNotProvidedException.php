<?php

namespace Yansongda\LaravelApi\Exceptions;

class AccessTokenNotProvidedException extends Exception
{
    /**
     * Raw data.
     *
     * @var string|array
     */
    public $raw;

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string       $message
     * @param string|array $raw
     * @param string|int   $code
     */
    public function __construct($message, $raw = '', $code = 1)
    {
        $this->raw = $raw;

        parent::__construct($message, intval($code));
    }
}
