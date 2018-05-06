<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Store;
use App\Http\Helpers;

class StoreController extends Controller
{

    public function index()
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

        return view('admin.store.index', compact('allStores', 'stores', 'activeStores', 'trialStores', 'inactiveStores'));
    }


    public function show($id)
    {
        $store = Store::findOrFail($id);
        return view('admin.store.show', compact('store'));
    }

}