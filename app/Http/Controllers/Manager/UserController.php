<?php
namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers;
use App\User;
use Validator;
use Auth;
use Hash;

class UserController extends Controller
{
	public function show()
	{
		$user = Auth::user();
		return view('manager.my-account', compact('user'));
	}





	public function updatePersonal( Request $request )
	{
		$validator = Validator::make($request->all(), [
			'first_name' 	=> 	'required|string|max:100',
            'last_name' 	=> 	'required|string|max:100',
            'email' 		=> 	'required|email|max:100',
		]);
		if( $validator->fails() ) :
			return redirect()->back()->withErrors($validator, 'personal');
		endif;

		$exists = User::where('email', $request->email)->where('id', '<>', Auth::user()->id)->first();
		if( $exists ) return redirect()->back()->withErrors(['personal' => 'Email is already registered to a different account.']);

		Auth::user()->first_name = $request->first_name;
		Auth::user()->last_name = $request->last_name;
		Auth::user()->email = $request->email;
		Auth::user()->save();

        return redirect()->back()->with('_notifyMessage', 'Personal information successfully updated.');
	}





	public function updateSecurity( Request $request )
	{
		$user = Auth::user();
		if( $user->password ) :
			$validator = Validator::make($request->all(), [
				'current_password' 	=> 	'required|string|max:100',
	            'password' 			=> 	'required|confirmed|max:100',
			]);
		else :
			$validator = Validator::make($request->all(), [
	            'password' 			=> 	'required|confirmed|max:100',
			]);
		endif;

		if( $validator->fails() ) :
			return redirect()->back()->withErrors($validator, 'security');
		endif;
		if( !$user->password || Hash::check( $request->current_password, $user->password) ) :
			$user->password = bcrypt($request->password);
			$user->save();
        	return redirect()->back()->with('_notifyMessage', 'Password successfully updated.');
		else :
			return redirect()->back()->withErrors(['security' => 'Invalid current password.']);
		endif;
	}



	public function updateContact( Request $request )
	{
		$validator = Validator::make($request->all(), [
			'street' 	=> 	'required|string|max:100',
            'city' 		=> 	'required|string|max:100',
            'province'	=> 	'required|string|max:100',
            'zip' 		=> 	'required|string|max:10',
            'phone' 	=> 	'required|string|max:50',
		]);
		if( $validator->fails() ) :
			return redirect()->back()->withErrors($validator, 'contact');
		endif;

        if( Helpers::validPHNumber($request->phone) ) :
			Auth::user()->street = $request->street;
			Auth::user()->city = $request->city;
			Auth::user()->province = $request->province;
			Auth::user()->zip = $request->zip;
			Auth::user()->phone = $request->phone;
			Auth::user()->save();
        	return redirect()->back()->with('_notifyMessage', 'Contact details successfully updated.');
        else :
            return redirect()->back()->withErrors(['contact' => 'Invalid phone number.']);
        endif;
	}



	public function updateEmailNotifications( Request $request )
	{
		$email_notifications = '[]';
		if( $request->email_notifications ) :
			$email_notifications = json_encode($request->email_notifications);
		endif;
		Auth::user()->email_notifications = $email_notifications;
		Auth::user()->save();

        return redirect()->back()->with('_notifyMessage', 'Email notifications successfully updated.');
	}
}