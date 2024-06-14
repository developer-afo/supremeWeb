<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth as Middleware;

class AuthenticateWithBasicAuth extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        return $this->auth->guard('api')->basic() ?: parent::authenticate($request, $guards);
    }
}
