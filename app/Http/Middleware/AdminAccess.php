<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;

class AdminAccess
{
    protected $auth;
    
    /**
        * Creates a new instance of the middleware.
        *
        * @param Guard $auth
        */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if ( ! Auth::user() || ! Auth::user()->hasRole('admin')) 
        {
            return redirect("/admin/signin");
        }

        return $next($request);
    }
}
