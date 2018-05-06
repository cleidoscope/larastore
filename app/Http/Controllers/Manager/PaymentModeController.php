<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentModeCreateRequest;
use App\Store;
use App\PaymentMode;
use Auth;
use Validator;

class PaymentModeController extends Controller
{

	public function store($store_id, PaymentModeCreateRequest $request)
	{
        $store = Store::findOrFail($store_id);
        
        if( Auth::user()->can('manageStore', $store) ) :

            PaymentMode::create([
                'store_id'       =>   $store->id,
                'title'          =>   $request->title,
                'description'    =>   $request->description,
            ]);
            return redirect()->back()->with('_notifyMessage', 'Payment mode successfully created.');
        else :
            return abort('403');
        endif;	
	}



	public function update($store_id, $id, PaymentModeCreateRequest $request)
	{

		$store = Store::findOrFail($store_id);
		$paymentMode = PaymentMode::findOrFail($id);
        
        if( Auth::user()->can('managePaymentMode', $paymentMode) &&
            $paymentMode->store_id == $store->id
        ) :
            $paymentMode->title          =   $request->title;
            $paymentMode->description    =   $request->description;
            $paymentMode->save();
            return redirect()->back()->with('_notifyMessage', 'Payment mode successfully updated.');
        else :
            return abort('403');
        endif;	
	}



	public function destroy($store_id, $id, Request $request)
	{
		$store = Store::findOrFail($store_id);
        $paymentMode = PaymentMode::findOrFail($id);
        
        if( Auth::user()->can('managePaymentMode', $paymentMode) &&
            $paymentMode->store_id == $store->id
        ) :
    		$paymentMode->forceDelete();
    		return redirect()->back()->with('_notifyMessage', 'Payment mode successfully deleted.');
        else :
            return abort('403');
        endif;  
	}


}