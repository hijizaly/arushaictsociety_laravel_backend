<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {


        if ($this->auth->guard('users-api')->check()) {
//                return $this->auth->shouldUse('members-api');
            return $this->auth->shouldUse('users-api');
        }

        $this->unauthenticated($request, ['users-api']);
    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('tt');
        }
    }
}
