<?php

namespace Yansongda\LaravelApi\Exceptions;

class Exception extends \Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception to http request.
     *
     * @param  \Illuminate\Http\Request
     * @return void
     */
    public function render($request)
    {
        return response()->json([
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        ]);
    }
}
