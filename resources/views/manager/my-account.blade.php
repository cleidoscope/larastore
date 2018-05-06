@extends('manager.layout')

@section('body-class')
"body-dimmed"
@stop

@section('title')
<title>My Account &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<h3 class="text-center font-regular font-massive">Account Settings</h3>
<div class="ui container">
	<div class="ui stackable two cards">
		<!-- Personal Information -->
		<div class="card">
			<div class="content">
				<div class="ui header">Personal Information</div>
				<form class="ui form has-loader" action="{{ route('manager.user.update.personal') }}" method="POST" id="formPersonal">
					{{ csrf_field() }}
					<div class="field">
						<label class="required">First Name</label>
						<input type="text" name="first_name" placeholder="First Name" value="{{ $user->first_name }}">
					</div>
					<div class="field">
						<label class="required">Last Name</label>
						<input type="text" name="last_name" placeholder="Last Name" value="{{ $user->last_name }}">
					</div>
					<div class="field">
						<label class="required">Email</label>
						<input type="email" name="email" placeholder="Email" value="{{ $user->email }}">
					</div>
					<div class="text-right">
						<button type="submit" class="ui primary circular small button has-loader-button">Save</button>
					</div>
				</form>
				@if ( $errors->personal->any() || $errors->has('personal') )
				<div class="ui error small message">
					<ul class="list">
		            	@foreach( $errors->personal->all() as $error )
		                <li>{!! $error !!}</li>
		                @endforeach
		                @if( $errors->has('personal') )
		                <li>{!! $errors->first('personal') !!}</li>
		                @endif
					 </ul>
				</div>
	            @endif
			</div>
		</div>

		<!-- Security -->
		<div class="card">
			<div class="content">
				<div class="ui header">Security</div>
				<form class="ui form has-loader" action="{{ route('manager.user.update.security') }}" method="POST" id="formSecurity">
					{{ csrf_field() }}
					@if( $user->password )
					<div class="field">
						<label class="required">Current Password</label>
						<input type="password" name="current_password">
					</div>
					@endif
					<div class="field">
						<label class="required">New Password</label>
						<input type="password" name="password">
					</div>
					<div class="field">
						<label class="required">Confirm Password</label>
						<input type="password" name="password_confirmation">
					</div>
					<div class="text-right">
						<button type="submit" class="ui primary small circular button has-loader-button">Save</button>
					</div>
				</form>
				@if( $errors->security->any() || $errors->has('security') )
				<div class="ui error small message">
					<ul class="list">
		            	@foreach( $errors->security->all() as $error )
		                <li>{!! $error !!}</li>
		                @endforeach
		                @if( $errors->has('security') )
		                <li>{!! $errors->first('security') !!}</li>
		                @endif
					 </ul>
				</div>
	            @endif
			</div>
		</div>


		<!-- Contact Details -->
		<div class="card">
			<div class="content">
				<div class="ui header">Contact Details</div>
				<form class="ui form has-loader" action="{{ route('manager.user.update.contact') }}" method="POST" id="formContact">
					{{ csrf_field() }}
					<div class="field">
						<label class="required">Street</label>
						<input type="text" name="street" placeholder="Street" value="{{ $user->street }}">
					</div>
					<div class="two fields">
						<div class="field">
							<label class="required">City</label>
							<input type="text" name="city" placeholder="City" value="{{ $user->city }}">
						</div>
						<div class="field">
							<label class="required">Province</label>
							<input type="text" name="province" placeholder="Province" value="{{ $user->province }}">
						</div>
					</div>
					<div class="two fields">
						<div class="field">
							<label class="required">ZIP</label>
							<input type="text" name="zip" placeholder="ZIP" value="{{ $user->zip }}">
						</div>
						<div class="field">
							<label class="required">Phone</label>
							<input type="text" name="phone" placeholder="Mobile Number" maxlength="11" value="{{ $user->phone }}">
							<p class="font-light font-small margin-top half">Example format: 09123456789</p>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="ui primary small circular button has-loader-button">Save</button>
					</div>
				</form>
				@if ( $errors->contact->any() || $errors->has('contact') )
				<div class="ui error small message">
					<ul class="list">
		            	@foreach( $errors->contact->all() as $error )
		                <li>{!! $error !!}</li>
		                @endforeach
		                @if( $errors->has('contact') )
		                <li>{!! $errors->first('contact') !!}</li>
		                @endif
					 </ul>
				</div>
	            @endif
			</div>
		</div>


		<!-- Email Notifications -->
		<div class="card">
			<div class="content">
				<div class="ui header">Email Notifications</div>
				<form class="ui form has-loader" action="{{ route('manager.user.update.email_notifications') }}" method="POST" id="formNotifications">
					{{ csrf_field() }}
					<div class="field margin-bottom half">
						<label class="font-bold">Email me when</label>
						<div class="ui checkbox">
				        	<input type="checkbox" name="email_notifications[]" value="1" tabindex="0" class="hidden" @if( in_array(1, $user->email_notifications) ) checked @endif>
				        	<label>Someone placed an order from my store</label>
					    </div>
					</div>
					<div class="field margin-bottom half">
						<div class="ui checkbox">
				        	<input type="checkbox" name="email_notifications[]" value="2" tabindex="0" class="hidden" @if( in_array(2, $user->email_notifications) ) checked @endif>
				        	<label>I place an order</label>
					    </div>
					</div>
					<div class="field margin-bottom half">
						<div class="ui checkbox">
				        	<input type="checkbox" name="email_notifications[]" value="3" tabindex="0" class="hidden" @if( in_array(3, $user->email_notifications) ) checked @endif>
				        	<label>Someone subscribes to my store</label>
					    </div>
					</div>
					<div class="field margin-bottom half">
						<div class="ui checkbox">
				        	<input type="checkbox" name="email_notifications[]" value="4" tabindex="0" class="hidden" @if( in_array(4, $user->email_notifications) ) checked @endif>
				        	<label>Someone submitted a review on my product</label>
					    </div>
					</div>
					<div class="field margin-top">
						<label class="font-bold">Email me with</label>
						<div class="ui checkbox">
				        	<input type="checkbox" name="email_notifications[]" value="5" tabindex="0" class="hidden" @if( in_array(5, $user->email_notifications) ) checked @endif>
				        	<label>Regular updates from Cloudstore Philippines</label>
					    </div>
					</div>

					<div class="text-right">
						<button type="submit" class="ui primary small circular button has-loader-button">Save</button>
					</div>
				</form>
				@if ( $errors->contact->any() || $errors->has('contact') )
				<div class="ui error small message">
					<ul class="list">
		            	@foreach( $errors->contact->all() as $error )
		                <li>{!! $error !!}</li>
		                @endforeach
					 </ul>
				</div>
	            @endif
			</div>
		</div>
	</div>
</div>
@stop

@section('scripts')
<script>
$('#formPersonal')
.form({
fields: {
	first_name 	: 'empty',
	last_name 	: 'empty',
	email 		: ['empty', 'email'],
}
});

$('#formSecurity')
.form({
fields: {
	current_password 			: 'empty',
	password 					: 'empty',
	password_confirmation 		: 'empty',
}
});


$('#formContact')
.form({
fields: {
	street 		: 'empty',
	city 		: 'empty',
	province 	: 'empty',
	zip 		: 'empty',
	phone		: ['empty', 'number', 'maxLength[11]', 'regExp[/^$|^(09|){2}\\d{9}$/]'],
}
});
</script>
@include('auth.partials.facebook-login')
@stop