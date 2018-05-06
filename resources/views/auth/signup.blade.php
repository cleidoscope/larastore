@extends('manager.layout')

@section('body-class')
"body-dimmed"
@stop

@section('title')
<title>Register &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<div class="ui inverted dimmer" id="loginLoader">
<div class="ui text loader">Logging in...</div>
</div>

<div class="ui container">
	<div class="ui stackable grid">
		<div class="sixteen wide mobile three wide tablet wide five wide computer column"></div>
		<div class="sixteen wide mobile ten wide tablet wide six wide computer column">
			<div class="text-center margin-bottom">
				<h2 class="font-big no-margin-bottom">Create an account for free</h2>
				<span>Signing up is simple and fast. Join us now and start selling.</span>
			</div>
			<br />
			<button class="ui button facebook fluid labeled large icon margin-bottom" onclick="FacebookLogin()" id="FBLoginButton"><i class="facebook icon"></i>Sign up with Facebook</button>

			<div class="text-center text-extra-grey margin-top margin-bottom">or</div>
				
			<form method="POST" action="{{route('auth.signup.store')}}" id="registerForm" class="ui form has-loader">
				{{csrf_field()}}
				<div class="field">
						<label>First Name</label>
					<input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name') }}">
				</div>
				<div class="field">
						<label>Last Name</label>
					<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}">
				</div>
				<div class="field">
						<label>Email</label>
					<input type="email" name="email" class="form-control" placeholder="Email">
				</div>
				<div class="field">
						<label>Password</label>
					<input type="password" name="password" class="form-control" placeholder="Password">
				</div>
				<div class="margin-bottom font-small">By <strong>Signing Up</strong>, you agree that you've read and accepted Cloudstore's <a href="">Conditions of Use</a> and <a href="{{ route('manager.privacy_policy') }}">Privacy Policy</a>.</div>

				<div class="text-center">
					<button type="submit" class="ui primary medium circular button has-loader-button margin-bottom half">Sign Up</button>
					<p class="font-regular">Already have an account? <strong><a href="{{route('auth.login.form')}}">Log In</a></strong></p>
				</div>
			</form>
			
			@if ( $errors->any() )
			<div class="ui error small message">
			  <ul class="list">
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
			  </ul>
			</div>
            @endif
		</div>
	</div>
</div>
@stop

@section('scripts')
<script type="text/javascript">
$('#registerForm')
.form({
fields: {
	first_name : 'empty',
  	last_name : 'empty',
	email : ['empty', 'email'],
  	password : 'empty',
}
});
</script>
@include('auth.partials.facebook-login')
@stop