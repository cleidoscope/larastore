@extends('manager.layout')

@section('title')
<title>Password Update &rsaquo; {{ config('app.name')}}</title>
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
						Password updated
					</h3>
					<span>Your password has been successfully updated</span>
					<div class="margin-top">
						<a class="ui primary circular button" href="{{ route('auth.login.form') }}">Login</a>
					</div>
				</div>
				<br />
				<br />
				@else
				<div class="text-center margin-bottom">
					<h3 class="font-big no-margin-bottom">Update password</h3>
				</div>
				<div class="margin-top">&nbsp;</div>
				<form method="POST" action="{{ route('auth.recover.update', $token) }}" id="resetForm" class="ui form has-loader">
					{{csrf_field()}}
					<div class="field @if ( $errors->any() ) error @endif">
						<label>New Password</label>
						<input type="password" name="password" placeholder="New Password">
					</div>
					
					<div class="field @if ( $errors->any() ) error @endif">
						<label>Confirm Password</label>
						<input type="password" name="password_confirmation" placeholder="Confirm Password">
					</div>
					<div class="text-right">
						<button type="submit" class="ui primary button has-loader-button">Update password</button>
					</div>
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
$('#resetForm')
.form({
fields: {
	password : 'empty',
	password_confirmation : 'empty'
}
});
</script>
@stop
