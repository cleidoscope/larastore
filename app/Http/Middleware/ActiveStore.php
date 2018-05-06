<?php
namespace App\Http\Middleware;

use Closure;
use Route;
use App\Http\Helpers;
use App\Store;

class ActiveStore
{

    public function handle($request, Closure $next)
    {
      $domain = parse_url(url(''), PHP_URL_HOST);
      $subdomain = Helpers::getSubdomain(url(''));
      $store = Store::whereIn('subdomain', compact('domain', 'subdomain'))->firstOrFail();


     	if( $store->is_active || Helpers::storeInTrial($store) ) :
      	return $next($request);
      else :
        return response(abort('503'));
     	endif;
    }
}

