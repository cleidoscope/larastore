@extends('manager.layout')

@section('title')
<title>Forgot Password &rsaquo; {{ config('app.name')}}</title>
@stop


@section('content')
<div class="ui container">
	<div class="ui stackable grid">
		<div class="sixteen wide mobile three wide tablet five wide computer column"></div>
		<div class="sixteen wide mobile ten wide tablet six wide computer column">
			<div class="auth-container">
				@if( session()->has('success') )
				<br />
				<br />
				<div class="text-center margin-bottom">
					<h3 class="font-big no-margin-bottom no-margin-top">
						<i class="fa fa-check  text-green"></i>
						<br />
						Password reset link sent
					</h3>
					<span>We have sent you the instructions on how to reset your password</span>
				</div>
				<br />
				<br />
				@else
				<div class="text-center margin-bottom">
					<h3 class="font-big no-margin-bottom">Forgot your password?</h3>
					<span>We'll email you instructions on how to reset it</span>
				</div>
				<div class="margin-top">&nbsp;</div>
				<form method="POST" action="{{ route('auth.recover.send') }}" id="recoverForm" class="ui form has-loader">
					{{csrf_field()}}
					<div class="field @if ( $errors->any() ) error @endif">
						<label>Email</label>
						<input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
					</div>

					<a class="ui medium circular labeled icon button" href="{{route('auth.login.form')}}"><i class="icon chevron left"></i>Login</a>
					<button type="submit" class="ui primary circular button pull-right has-loader-button">Send reset link</button>
				</form>
	           
	           	<div id="errors-container" class="margin-top"> 
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
				@endif
			</div>
		</div>
	</div>
</div>
@stop

@section('scripts')
<script>
$('#recoverForm')
.form({
fields: {
	email : ['empty', 'email']
}
});
</script>
@stop
