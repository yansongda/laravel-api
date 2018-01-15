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
     * @param string|int   $code
     * @param string|array $raw
     */
    public function __construct($message, $code, $raw = '')
    {
        $this->raw = $raw;

        parent::__construct($message, intval($code));
    }
}
