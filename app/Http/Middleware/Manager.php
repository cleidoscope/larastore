<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Manager
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if ( $this->auth->guest() ) :
            return response(view('auth.login'));
        endif;

        return $next($request);
    }
}

