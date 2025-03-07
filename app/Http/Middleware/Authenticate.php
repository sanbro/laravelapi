<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{

    /**
     * Handle unauthenticated requests for APIs.
     */
    protected function unauthenticated($request, array $guards)
    {

        abort(code: response()->json(['status' => false,'message' => 'You are not authenticated'], 401));
    }

     /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (Auth::guard('api')->guest()) {
            return $this->unauthenticated($request, []);
        }
        if (!$request->expectsJson()) {
            return route('login'); // Redirect only for web requests
        }
        return null;
    }
}
