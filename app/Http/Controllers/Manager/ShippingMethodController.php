<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Store;
use App\ShippingMethod;
use Auth;
use Validator;

class ShippingMethodController extends Controller
{

	public function store($store_id, Request $request)
	{
        $validator = $this->validator($request->all());
        if( $validator->fails() ) :
            return redirect()->back()->withInput()->withErrors($validator);
        endif;
        
        $store = Store::findOrFail($store_id);
        
        if( Auth::user()->can('manageStore', $store) ) :
            ShippingMethod::create([
                'store_id'       =>   $store->id,
                'title'          =>   $request->title,
            ]);
            return redirect()->back()->with('_notifyMessage', 'Shipping method successfully created.');
        else :
            return abort('403');
        endif;	
	}



	public function update($store_id, $id, Request $request)
	{
        $validator = $this->validator($request->all());
        if( $validator->fails() ) :
            return redirect()->back()->withInput()->withErrors($validator);
        endif;
        
		$store = Store::findOrFail($store_id);
		$shippingMethod = ShippingMethod::findOrFail($id);
        
        if( Auth::user()->can('manageShippingMethod', $shippingMethod) &&
            $shippingMethod->store_id = $store->id
        ) :
            $shippingMethod->title  =   $request->title;
            $shippingMethod->save();
            return redirect()->back()->with('_notifyMessage', 'Shipping method successfully updated.');
        else :
            return abort('403');
        endif;	
	}



	public function destroy($store_id, $id, Request $request)
	{
		$store = Store::findOrFail($store_id);
		$shippingMethod = ShippingMethod::findOrFail($id);
        
        if( Auth::user()->can('manageShippingMethod', $shippingMethod) &&
            $shippingMethod->store_id = $store->id
        ) :
    		$shippingMethod->forceDelete();
    		return redirect()->back()->with('_notifyMessage', 'Shipping method successfully deleted.');
        else :
            return abort('403');
        endif;  
	}


    public function validator($data)
    {
        return Validator::make($data, [
            'title'     => 'required|string|max:100',
        ]);
    }

}