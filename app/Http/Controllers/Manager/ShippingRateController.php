<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShippingMethod;
use App\ShippingRate;
use Auth;
use Validator;

class ShippingRateController extends Controller
{

	public function store($store_id, $method_id, Request $request)
	{
        $validator = $this->validator($request->all());
        if( $validator->fails() ) :
            return redirect()->back()->withInput()->withErrors($validator);
        endif;
        
        $shippingMethod = ShippingMethod::findOrFail($method_id);
        
        if( Auth::user()->can('manageShippingMethod', $shippingMethod) ) :
            $min = preg_replace('/[^0-9.]+/', '', $request->min);
            $min = $min ? (float)$min : 0.00;

            $max = preg_replace('/[^0-9.]+/', '', $request->max);
            $max = $max ? (float)$max : 0.00;

            $rate = preg_replace('/[^0-9.]+/', '', $request->rate);
            $rate = $rate ? (float)$rate : 0.00;
            ShippingRate::create([
                'shipping_method_id'        =>   $shippingMethod->id,
                'min'                       =>   $min,
                'max'                       =>   $max,
                'rate'                      =>   $rate,
            ]);
            return redirect()->back()->with('_notifyMessage', 'Shipping rate successfully added.');
        else :
            return abort('403');
        endif;	
	}



	public function update($store_id, $method_id, $id, Request $request)
	{
        $validator = $this->validator($request->all());
        if( $validator->fails() ) :
            return redirect()->back()->withInput()->withErrors($validator);
        endif;
        
        $shippingMethod = ShippingMethod::findOrFail($method_id);
		$shippingRate = ShippingRate::findOrFail($id);
        
        if( Auth::user()->can('manageShippingRate', $shippingRate) &&
            $shippingRate->shipping_method_id = $shippingMethod->id
        ) :
            $min = preg_replace('/[^0-9.]+/', '', $request->min);
            $min = $min ? (float)$min : 0.00;

            $max = preg_replace('/[^0-9.]+/', '', $request->max);
            $max = $max ? (float)$max : 0.00;

            $rate = preg_replace('/[^0-9.]+/', '', $request->rate);
            $rate = $rate ? (float)$rate : 0.00;

            $shippingRate->min  =  $min;
            $shippingRate->max  =  $max;
            $shippingRate->rate  =  $rate;
            $shippingRate->save();
            return redirect()->back()->with('_notifyMessage', 'Shipping rate successfully updated.');
        else :
            return abort('403');
        endif;	
	}



	public function destroy($store_id, $method_id, $id)
	{
        $shippingMethod = ShippingMethod::findOrFail($method_id);
        $shippingRate = ShippingRate::findOrFail($id);
        
        if( Auth::user()->can('manageShippingRate', $shippingRate) &&
            $shippingRate->shipping_method_id = $shippingMethod->id
        ) :
    		$shippingRate->forceDelete();
    		return redirect()->back()->with('_notifyMessage', 'Shipping rate successfully deleted.');
        else :
            return abort('403');
        endif;  
	}


    public function validator($data)
    {
        return Validator::make($data, [
            'min'     => 'required',
            'max'     => 'required',
            'rate'    => 'required',
        ]);
    }

}