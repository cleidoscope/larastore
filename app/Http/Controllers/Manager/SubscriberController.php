<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subscriber;
use Auth;
use Validator;

class SubscriberController extends Controller
{



	public function store(Request $request)
	{
        $validator = $this->validator($request->all());
        if( $validator->fails() ) :
            return redirect()->back()->withInput()->withErrors($validator);
        endif;

        $exists = Subscriber::where('email', $request->email)->first();
        if( !$exists ) :
            Subscriber::create([
                'full_name'    =>   $request->full_name,
                'email'        =>   $request->email,
            ]);
        endif;

        return redirect(route('manager.subscribed'));
	}





    public function validator($data)
    {
        return Validator::make($data, [
            'full_name'   =>  'required|string',
            'email'       =>  'required|email|string',
        ]);
    }

}