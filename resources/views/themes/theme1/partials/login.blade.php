<div class="ui xsmall modal" id="loginModal">
  	<div class="content">
	    <form method="POST" action="{{route('auth.login.store')}}" id="loginForm" class="ui form has-loader">
			{{csrf_field()}}
			<div class="field">
				<label>Email</label>
				<input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
			</div>
			<div class="field">
				<label>Password</label>
				<input type="password" name="password" placeholder="Password">
			</div>
			<button type="submit" class="ui primary button pull-right has-loader-button">Log In</button>
			<a href="{{ route('auth.recover') }}">Forgot password?</a> <br />
			<a href="{{ route('auth.signup.form') }}">Not yet registered?</a>
		</form>
		<br />
		<button class="ui button facebook fluid labeled large icon margin-bottom" onclick="FacebookLogin()"><i class="facebook icon"></i>Login with Facebook</button>
       
       	<div id="auth-errors-container"> 
			@if ( $errors->has('auth_error') )
			<div class="ui error small message">
			  <ul class="list">
			  	<li>{!! $errors->first('auth_error') !!}</li>
			  </ul>
			</div>
            @endif
        </div>  	
        
		<div class="text-right">
	    	<div class="ui circular icon button default mini" id="closeLogin"><i class="close icon"></i></div>
	    </div>
    </div>
</div>