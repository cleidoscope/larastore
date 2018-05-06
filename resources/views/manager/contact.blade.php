@extends('manager.layout')

@section('body-class')
"body-dimmed"
@stop

@section('title')
<title>Contact Us &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<div class="ui container">
	<div class="ui grid stackable margin-top text-center">
		<div class="sixteen wide mobile three wide tablet three wide computer column"></div>
		<div class="sixteen wide mobile ten wide tablet ten wide computer column">
			<h2 class="font-medium font-massive margin-bottom half">Got a question about using Cloudstore?</h2>
			<p>
			We're here to help! Our support team is available from 9am to 5pm - 7 days a week via phone, email, live chat, and social media messaging to answer your questions and suggestions.
			</p>
		</div>
	</div>
</div>


<div class="margin-top">&nbsp;</div>
<div class="margin-top">&nbsp;</div>

<div class="ui container margin-top margin-bottom text-center">
	<div class="ui four stackable doubling cards">
		<div class="card">
			<div class="content">
				<div class="header">
					<img src="{{ asset('images/phone.svg') }}" class="contact-icon">
					<div class="font-medium font-size-medium margin-top margin-bottom">Phone</div>
				</div>
				<div class="description">
					<p>Give us a call, send us a direct SMS, or message us using Whatsapp and Viber.</p>
				</div>
			</div>
		  	<div class="extra content">
				<span class="text-blue font-medium">09162792651</span>
		  	</div>
		</div>

		<div class="card">
			<div class="content">
				<div class="header">
					<img src="{{ asset('images/envelope.svg') }}" class="contact-icon">
					<div class="font-medium font-size-medium margin-top margin-bottom">Email</div>
				</div>
				<div class="description">
					<p>Reach us by email and we will be in touch as soon as possible.</p>
				</div>
			</div>
		  	<div class="extra content">
				<span class="text-blue font-medium">support@cloudstore.ph</span>
		  	</div>
		</div>

		<div class="card">
			<div class="content">
				<div class="header">
					<img src="{{ asset('images/chat.svg') }}" class="contact-icon">
					<div class="font-medium font-size-medium margin-top margin-bottom">Live Chat</div>
				</div>
				<div class="description">
					<p>Chat directly with us and get help with your questions and concerns.</p>
				</div>
			</div>
		  	<div class="extra content">
		  		<button class="ui button primary small" id="clickToChat">Chat with us</button>
		  	</div>
		</div>

		<div class="card">
			<div class="content">
				<div class="header">
					<img src="{{ asset('images/social-media.svg') }}" class="contact-icon">
					<div class="font-medium font-size-medium margin-top margin-bottom">Social Media</div>
				</div>
				<div class="description">
					<p>Message us on any of our social media accounts below.</p>
				</div>
			</div>
		  	<div class="extra content">
				<div class="font-size-medium">
					<a href="https://www.facebook.com/cloudstorephilippines/" target="_blank"><i class="fa fa-facebook-square margin-right text-blue"></i></a>
					<a href="https://twitter.com/cloudstore_ph" target="_blank"><i class="fa fa-twitter margin-left margin-right text-blue"></i></a>
					<a href="https://www.instagram.com/cloudstorephilippines/" target="_blank"><i class="fa fa-instagram margin-left text-blue"></i></a>
				</div>
		  	</div>
		</div>
	</div>
</div>


<div class="margin-bottom">&nbsp;</div>
@stop

@section('scripts')
<script>
	$(document).ready(function(){
		$('#clickToChat').click(function(){
			$('w-div').click();
		});
	});
</script>
@stop