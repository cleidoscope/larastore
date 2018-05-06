<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\FacebookLoginRequest;
use App\Http\Requests\RegisterRequest;
use App\User;
use App\UserActivity;
use App\PasswordReset;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\Welcome;
use App\Mail\SendPasswordReset;
use App\Mail\PasswordUpdateConfirmation;
use Validator;

class AuthController extends Controller
{
   

    // Show login form
    public function login()
    {
    	return view('auth.login');
    }
    




    // Attempt login from login form (onpage)
    public function store(LoginRequest $request)
    {
        if( Auth::attempt(['email' => $request->email, 'password' => $request->password]) ) :
            $user = User::where('email', $request->email)->first();
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();
            UserActivity::create([
                'user_id' => $user->id,
                'activity' => 'Logged in from onpage'
            ]);
            return redirect()->back();
        else :
            return redirect()->back()->withInput()->withErrors(['auth_error' => 'Wrong password.']);
        endif;
    }





    // Attempt login using Facebook (creates new user if not exists)
    public function facebookLogin(FacebookLoginRequest $request)
    {
        if( $request->ajax() ) :

            $response = [
                'success' => true,
                'redirect_url' => redirect()->back()->getTargetUrl(),
            ];

            $user = User::where('email', $request->email)->first();
            if( $user ) :
                Auth::login($user);
                UserActivity::create([
                    'user_id' => $user->id,
                    'activity' => 'Logged in with Facebook'
                ]);
            else :
                $user                       =      new User();
                $user->first_name           =      $request->first_name;
                $user->last_name            =      $request->last_name;
                $user->email                =      $request->email;
                $user->role                 =      \Roles::Manager();
                $user->registration_type    =      'facebook';
                Auth::login($user);
                Mail::to($user->email)->send(new Welcome($user));
                UserActivity::create([
                    'user_id' => $user->id,
                    'activity' => 'Registered with Facebook'
                ]);
            endif;
            
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();
            

            return json_encode($response);
        else :
            return response('Unauthorized.', 401);
        endif;
    }





    // Show registration form
    public function signup()
    {
    	return view('auth.signup');
    }




    // Create new user from registration form
    public function create(RegisterRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if( $user ) :
            return redirect()->back()->withErrors(['Email is already taken.'])->withInput();
        else :
            $user                       =      new User();
            $user->first_name           =      $request->first_name;
            $user->last_name            =      $request->last_name;
            $user->email                =      $request->email;
            $user->password             =      bcrypt($request->password);
            $user->role                 =      \Roles::Manager();
            $user->registration_type    =      'onpage';
            $user->save();
        endif;
        Auth::login($user);
        Mail::to($user->email)->send(new Welcome($user));
        UserActivity::create([
            'user_id' => $user->id,
            'activity' => 'Registered with onpage'
        ]);

        return redirect(route('manager.store.index'));
    }
    



    // Password reset
    public function recover()
    {
        return view('auth.recover');
    }
    





    // Send password reset link to email
    public function recoverSend(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if( $user ) :
            PasswordReset::where('email', $request->email)->delete();
            $i = 0;
            while( $i == 0 ) :
                $token = Str::random(30);
                $exists = PasswordReset::where('token', $token)->first();
                if( !$exists ) break;
            endwhile;
            $passwordReset = new PasswordReset();
            $passwordReset->email = $request->email;
            $passwordReset->token = $token;
            $passwordReset->save();
            Mail::to($request->email)->send(new SendPasswordReset($passwordReset));
            UserActivity::create([
                'user_id' => $user->id,
                'activity' => 'Requested a password reset'
            ]);
            return redirect()->back()->with('success', []);
        else :
            return redirect()->back()->withInput()->withErrors(['We could not find the email address in our records.']);
        endif;
    }






    // Password reset form
    public function recoverReset($token, Request $request)
    {
        $passwordReset = PasswordReset::where('token', $token)->firstOrfail();
        return view('auth.reset', compact('token'));
    }







    // Update password
    public function recoverUpdate($token, Request $request)
    {
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();

        $validator = Validator::make($request->all(),[
            'password' => 'required|confirmed|max:100',
        ]);
        if( $validator->fails() ) return redirect()->back()->withErrors($validator);

        $user = User::where('email', $passwordReset->email)->first();
        if( $user ) :
            $user->password = bcrypt($request->password);
            $user->save();
            Mail::to($passwordReset->email)->send(new PasswordUpdateConfirmation());
            UserActivity::create([
                'user_id' => $user->id,
                'activity' => 'Updated the password from password reset request'
            ]);
            return redirect()->back()->with('success', '');
        else :
            return redirect()->back()->withErrors('The email associated with this reset token does not exist anymore.');
        endif;
    }









    // Logout user
    public function logout()
    {
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'activity' => 'Logged out'
        ]);
        Auth::logout();
        return redirect(url(''));
    }

}
