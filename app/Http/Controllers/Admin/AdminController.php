<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Store;
use App\User;
use App\Order;
use App\Invoice;
use Auth;
use App\Http\Helpers;
use Validator;

class AdminController extends Controller
{

    public function stores()
    {
    	$allStores = Store::all();
    	$stores = Store::orderBy('created_at', 'desc')->paginate(15);

    	$activeStores = $allStores->where('is_active', true)->count();
    	$trialStores = $allStores->filter(function($value, $key){
    		return !$value->is_active && Helpers::storeInTrial($value);
    	})->count();
    	$inactiveStores = $allStores->filter(function($value, $key){
    		return !$value->is_active && !Helpers::storeInTrial($value);
    	})->count();

        return view('admin.stores', compact('allStores', 'stores', 'activeStores', 'trialStores', 'inactiveStores'));
    }

}