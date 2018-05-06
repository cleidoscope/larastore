<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Store;
use App\Voucher;
use Auth;
use Validator;

class VoucherController extends Controller
{

	public function index($store_id, Request $request)
	{
		$store = Store::findOrFail($store_id);

        if( Auth::user()->can('manageStore', $store) && !$store->is_basic) :
            return view('manager.store.store-manager.voucher.index', compact('store'));
        else :
            return abort('403');
        endif;
	}






	public function store($store_id, Request $request)
	{
        $validator = $this->validator($request->all());
        if( $validator->fails() ) :
            return redirect()->back()->withInput()->withErrors($validator);
        endif;

        $store = Store::findOrFail($store_id);
        
        if( Auth::user()->can('manageStore', $store)  && !$store->is_basic) :
        	$exists = Voucher::where('code', $request->code)->first();
        	if( $exists ) :
        		return redirect()->back()->withInput()->withErrors(['_addVoucherError' => 'Voucher code already exists. Please enter another code.']);
        	else :
        		Voucher::create([
        			'code'       	=>   $request->code,
        			'discount' 	   	=>   $request->discount,
                    'store_id'      =>   $store->id,
        			'valid_until'	=>   $request->valid_until,
        		]);
        		return redirect()->back()->with('_notifyMessage', 'Voucher successfully created.');
        	endif;
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
		$voucher = Voucher::findOrFail($id);
        
        if( Auth::user()->can('manageVoucher', $voucher) &&
            $voucher->store_id == $store->id &&
            !$store->is_basic
        ) :
        	$exists = Voucher::where('id', '<>', $id)->where('code', $request->code)->first();
        	if( $exists ) :
        		return redirect()->back()->withInput()->withErrors(['_editVoucherError' => 'Voucher code already exists. Please enter another voucher.', 'oldAction' => route('manager.voucher.update', ['store_id' => $store->id, 'id' => $voucher->id])]);
        	else :
        		$voucher->code        =   $request->code;
        		$voucher->discount    =   $request->discount;
                $voucher->valid_until =   $request->valid_until;
        		$voucher->save();
        		return redirect()->back()->with('_notifyMessage', 'Voucher successfully updated.');
        	endif;
        else :
            return abort('403');
        endif;	
	}





	public function destroy($store_id, $id, Request $request)
	{
		$store = Store::findOrFail($store_id);
		$voucher = Voucher::findOrFail($id);
        
        if( Auth::user()->can('manageVoucher', $voucher) &&
            $voucher->store_id == $store->id &&
            !$store->is_basic
        ) :
    		$voucher->forceDelete();
    		return redirect()->back()->with('_notifyMessage', 'Voucher successfully deleted.');
        else :
            return abort('403');
        endif;  
	}




    public function validator($data)
    {
        return Validator::make($data, [
            'code' => 'required|string',
            'discount' => 'required|numeric|min:0.01',
            'valid_until' => 'required|date',
        ]);
    }

}