<?php
namespace App\Http\Middleware;

use Closure;
use Route;
use App\Store;
use App\Invoice;
use App\Http\Helpers;
use Auth;

class ValidateStore
{

    public function handle($request, Closure $next)
    {
      $store = Store::find($request->store_id);

      if( $store ) :
        if( Auth::user()->can('manageStore', $store) ) :
         	if( $store->is_active || Helpers::storeInTrial($store) ) :
          	return $next($request);
          else :
            $invoice = Helpers::hasInvoice($store);
            return response(view('manager.store.trial-ended', compact('store', 'invoice')));
          endif;
        else :
          return response(abort('404'));
        endif;
      else :
        return response(abort('403'));
     	endif;
    }
}

