<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Admin
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if ( $this->auth->guest() ) :
            return response(view('admin.auth.login'));
        else :
            if ( $this->auth->user()->role != \Roles::Admin() ) :
                return response(abort('403'));
            endif;
        endif;

        return $next($request);
    }
}

