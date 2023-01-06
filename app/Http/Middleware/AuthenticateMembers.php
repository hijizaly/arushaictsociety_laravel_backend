<?php

namespace App\Http\Middleware;

use App\Http\Controllers\MembersController;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateMembers extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard('members-api')->check()) {
//                return $this->auth->shouldUse('members-api');
            return $this->auth->shouldUse('members-api');
        }

        $this->unauthenticated($request, ['members-api']);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('unauthorized');
//            return response()->setStatusCode(401);
        }else{
//            echo("requests not pro");
        }

//        return $request->expectsJson()
//            ? response()->json(['message' => 'bla bla bla'], 401)
//            : redirect()->guest($exception->redirectTo() ?? route('login'));

//        if (! $request->expectsJson()){
//        response()->json(['message' => 'bla bla bla'], 401);
//
//        }

    }
}
