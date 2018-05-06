@extends('manager.layout')

@section('body-class')
"body-dimmed"
@stop

@section('title')
<title>Thank You For Subscribing &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<div class="ui container">
	<h2 class="text-center font-regular font-massive">Thank you for subscribing!</h2>
</div>

<div class="ui container">
	<div class="ui grid stackable margin-top">
		<div class="sixteen wide mobile three wide tablet three wide computer column"></div>
		<div class="sixteen wide mobile ten wide tablet ten wide computer column">
			<p class="subscribed-body">
				We're so glad to have you as a part of the community.  Starting today, you will be the first to know about all the exciting updates and features that will be rolled out in the future. You will be receiving emails about future release updates, tips on how to improve your store, promos, and more. In addition to that, you will also find original articles, blogs, and fun posts that show you what happens behind the scenes at CloudStore. We might even give out some freebies, so stay tuned for that!
				<br /><br />
				Never miss an opportunity to start selling your goods. With Cloudstore, your dream of becoming a successful seller is now at hand. By subscribing to our email newsletters, you're taking the first steps towards that dream of yours. Enjoy our subscriber-only deals and programs that  are guaranteed to make things easier for you and your business.
				<br /><br />
				These newsletters work best if you're a registered member. Still not registered? Click <a href="{{ route('auth.login.form') }}">here</a> to signup and get a FREE 30-day trial store will all the Plus Plan features! Starting a business has never been easier. 
			</p>
			<br />
			<p class="margin-top margin-bottom text-grey font-small">
				If you wish to opt-out from our mailing list, you can always update your email notifications settings from your account page.
			</p>
		</div>
	</div>
</div>

@stop