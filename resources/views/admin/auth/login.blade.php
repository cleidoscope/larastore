@extends('admin.layout')

@section('title')
<title>Login &rsaquo; Admin - {{ config('app.name')}}</title>
@stop



@section('content')
<div class="ui inverted dimmer" id="loginLoader">
<div class="ui text loader">Logging in...</div>
</div>

<div class="login-form">
	<div class="ui container">
		<div class="ui stackable grid">
			<div class="sixteen wide mobile three wide tablet five wide computer column"></div>
			<div class="sixteen wide mobile ten wide tablet six wide computer column">
				<div class="auth-container">
					<form method="POST" action="{{ route('auth.login.store') }}" id="onpageLoginForm" class="ui form has-loader margin-bottom">
						{{ csrf_field() }}
						<div class="field">
							<label>Email</label>
							<input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
						</div>
						<div class="field">
							<label>Password</label>
							<input type="password" name="password" placeholder="Password">
						</div>
						<div class="text-right">
							<button type="submit" class="ui primary button has-loader-button">Log In</button>
						</div>
					</form>
					<button class="ui button facebook fluid labeled large icon margin-bottom" onclick="FacebookLogin()" id="FBLoginButton"><i class="facebook icon"></i>Login with Facebook</button>
		           
		           	<div id="auth-errors-container"> 
						@if ( $errors->any() )
						<div class="ui error small message">
						  <ul class="list">
			                @foreach( $errors->all() as $error )
			                <li>{!! $error !!}</li>
			                @endforeach
						  </ul>
						</div>
			            @endif
		            </div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('scripts')
<script>
$(document).ready(function(){
	$('#onpageLoginForm')
	.form({
	fields: {
		email : ['empty', 'email'],
	  	password : 'empty',
	}
	});
});
</script>
@include('auth.partials.facebook-login')
@stop