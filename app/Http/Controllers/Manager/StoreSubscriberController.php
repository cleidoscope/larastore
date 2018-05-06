<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Store;
use App\StoreSubscriber;
use Auth;
use Validator;

class StoreSubscriberController extends Controller
{

	public function index($store_id, Request $request)
	{
		$store = Store::findOrFail($store_id);

        if( Auth::user()->can('manageStore', $store) && !$store->is_basic) :
            return view('manager.store.store-manager.store-subscriber.index', compact('store'));
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
        
        if( Auth::user()->can('manageStore', $store) && !$store->is_basic) :
            $exists = StoreSubscriber::where('email', $request->email)->first();
            if( $exists ) :
                return redirect()->back()->withInput()->withErrors(['_addSubscriberError' => 'Email already exists.']);
            else :
            	StoreSubscriber::create([
                    'store_id'     =>   $store->id,
                    'full_name'    =>   $request->full_name,
                    'email'        =>   $request->email,
                ]);
                return redirect()->back()->with('_notifyMessage', 'Subscriber successfully created.');
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
		$storeSubscriber = StoreSubscriber::findOrFail($id);
        
        if( Auth::user()->can('manageStoreSubscriber', $storeSubscriber) &&
            $storeSubscriber->store_id == $store->id &&
            !$store->is_basic
        ) :
            $exists = StoreSubscriber::where('id', '<>', $id)->where('email', $request->email)->first();
            if( $exists ) :
                return redirect()->back()->withInput()->withErrors(['_editSubscriberError' => 'Email already exists.', 'oldAction' => route('manager.subscriber.update', ['store_id' => $store->id, 'id' => $storeSubscriber->id])]);
            else :
                $storeSubscriber->full_name    =   $request->full_name;
                $storeSubscriber->email        =   $request->email;
                $storeSubscriber->save();
                return redirect()->back()->with('_notifyMessage', 'Subscriber successfully updated.');
            endif;
        else :
            return abort('403');
        endif;	
	}




	public function destroy($store_id, $id, Request $request)
	{
		$store = Store::findOrFail($store_id);
		$storeSubscriber = StoreSubscriber::findOrFail($id);
        
        if( Auth::user()->can('manageStoreSubscriber', $storeSubscriber) &&
            $storeSubscriber->store_id == $store->id &&
            !$store->is_basic
        ) :
    		$storeSubscriber->forceDelete();
    		return redirect()->back()->with('_notifyMessage', 'Subscriber successfully deleted.');
        else :
            return abort('403');
        endif;  
	}




    public function validator($data)
    {
        return Validator::make($data, [
            'full_name'   =>  'required|string',
            'email'       =>  'required|email|string',
        ]);
    }

}