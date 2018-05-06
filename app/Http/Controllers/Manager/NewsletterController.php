<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Store;
use App\Newsletter;
use Auth;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNewsletter;

class NewsletterController extends Controller
{

	public function index($store_id, Request $request)
	{
		$store = Store::findOrFail($store_id);

        if( Auth::user()->can('manageStore', $store) && !$store->is_basic) :
            return view('manager.store.store-manager.newsletter.index', compact('store'));
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
        	Newsletter::create([
                'store_id'     =>   $store->id,
                'subject'      =>   $request->subject,
                'message'      =>   $request->message,
            ]);
            return redirect()->back()->with('_notifyMessage', 'Newsletter successfully created.');
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
		$newsletter = Newsletter::findOrFail($id);
        
        if( Auth::user()->can('manageNewsletter', $newsletter) &&
            $newsletter->store_id == $store->id &&
            !$store->is_basic
        ) :
            $newsletter->subject    =   $request->subject;
            $newsletter->message    =   $request->message;
            $newsletter->save();
            return redirect()->back()->with('_notifyMessage', 'Newsletter successfully updated.');
        else :
            return abort('403');
        endif;	
	}






	public function destroy($store_id, $id, Request $request)
	{
		$store = Store::findOrFail($store_id);
		$newsletter = Newsletter::findOrFail($id);
        
        if( Auth::user()->can('manageNewsletter', $newsletter) &&
            $newsletter->store_id == $store->id &&
            !$store->is_basic
        ) :
    		$newsletter->forceDelete();
    		return redirect()->back()->with('_notifyMessage', 'Newsletter successfully deleted.');
        else :
            return abort('403');
        endif;  
	}





    public function send($store_id, Request $request)
    {
        $store = Store::findOrFail($store_id);
        $newsletter = Newsletter::findOrFail($request->id);
        
        if( Auth::user()->can('manageNewsletter', $newsletter) &&
            $newsletter->store_id == $store->id &&
            !$store->is_basic
        ) :
            // Send newsletter
            switch( $request->recipient ) :
                case 'subscribers' :
                    foreach( $store->store_subscribers as $subscriber ) :
                        Mail::to($subscriber->email)->send(new SendNewsletter($newsletter));
                    endforeach;
                    return redirect()->back()->with('_notifyMessage', 'Newsletter successfully sent to subscribers.');
                    break;

                case 'email' :
                    Mail::to($request->email)->send(new SendNewsletter($newsletter));
                    return redirect()->back()->with('_notifyMessage', 'Newsletter successfully sent to email.');
                    break;
            endswitch;
        else :
            return abort('403');
        endif;  
    }




    public function validator($data)
    {
        return Validator::make($data, [
            'subject'   =>  'required|string',
            'message'   =>  'required|string',
        ]);
    }

}