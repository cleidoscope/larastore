@extends('manager.layout')

@section('title')
<title>{{ config('app.name')}}</title>
@stop



@section('content')
<div class="hero text-center">
	<div class="ui container">
		<div class="ui stackable grid">
			<div class="sixtween wide mobile two wide tablet two wide computer column"></div>
			<div class="sixtween wide mobile twelve wide tablet twelve wide computer column">
				<h1 class="no-margin-bottom font-medium text-black">Create your online store with Cloudstore</h1>
				<h2 class="font-size-medium font-light text-grey no-margin-top">Fast and beautifully created ecommerce platform packed with intelligent tools.</h2>

				<a href="{{ route('auth.login.form') }}" class="ui circular primary large button margin-top">Get started</a>

				<div class="hero-image"><img src="{{ asset('images/hero-image.png') }}"></div>
			</div>
		</div>
	</div>
</div>


<div id="home-features">
	<div class="ui container">
		<h2 class="font-massive text-center">Cloudstore is made for you</h2>

		<div class="ui stackable grid">
			<div class="row">
				<div class="sixteen wide mobile one wide tablet one wide computer column"></div>
				<div class="sixteen wide mobile seven wide tablet seven wide computer column text-center middle aligned mobile-only">
	    			<img src="{{ asset('images/responsive.svg') }}" alt="Free and beautiful themes" title="Free and beautiful themes">
				</div>
				<div class="sixteen wide mobile seven wide tablet seven wide computer column">
					<h3 class="font-big margin-bottom">Free and beautiful themes</h3>
		    		<p class="text-grey font-thin">
		    			Choose from a number of crafted themes to give your store a personalized look. All themes are perfectly responsive so you can rest assured that your store will work optimally on any device.
		    		</p>
		    		<a class="ui circular basic blue button">View Themes</a>
				</div>
				<div class="sixteen wide mobile seven wide tablet seven wide computer column text-center middle aligned computer-only">
	    			<img src="{{ asset('images/responsive.svg') }}" alt="Free and beautiful themes" title="Free and beautiful themes">
				</div>
			</div>

			<div class="row margin-top">
				<div class="sixteen wide mobile one wide tablet one wide computer column"></div>
				<div class="sixteen wide mobile seven wide tablet seven wide computer column text-center middle aligned">
    				<img src="{{ asset('images/analytics.svg') }}" alt="Monitor and optimize your store" title="Monitor and optimize your store">
				</div>
				<div class="sixteen wide mobile seven wide tablet seven wide computer column">
					<h3 class="font-big margin-bottom">Monitor and optimize your store</h3>
		    		<p class="text-grey font-thin">
	    				Cloudstore is equipped with advanced tools allowing you to keep a detailed track of your business performance. The intuitive and comprehensible tools are perfect for both experts and beginners alike.
		    		</p>
		    		<a class="ui circular basic blue button">Learn more</a>
				</div>
			</div>

			<div class="row margin-top">
				<div class="sixteen wide mobile one wide tablet one wide computer column"></div>
				<div class="sixteen wide mobile seven wide tablet seven wide computer column text-center middle aligned mobile-only">
    				<img src="{{ asset('images/notification.svg') }}" alt="Get notified anytime, anywhere" title="Get notified anytime, anywhere">
				</div>
				<div class="sixteen wide mobile seven wide tablet seven wide computer column">
					<h3 class="font-big margin-bottom">Get notified anytime, anywhere</h3>
		    		<p class="text-grey font-thin">
			    		Being on top of your business is a must! Cloudstore's SMS notification feature guarantees that you never overlook a single order. * <br />
						<em class="font-small">* Available on <strong><a href="{{ route('manager.pricing') }}">Plus</a></strong> and <strong><a href="{{ route('manager.pricing') }}">Pro</a></strong></em>
		    		</p>
		    		<a class="ui circular basic blue button" href="{{ route('manager.pricing') }}">Pricing and Features</a>
				</div>
				<div class="sixteen wide mobile seven wide tablet seven wide computer column text-center middle aligned computer-only">
    				<img src="{{ asset('images/notification.svg') }}" alt="Get notified anytime, anywhere" title="Get notified anytime, anywhere">
				</div>
			</div>
		</div>
	</div>
</div>


<div class="subscription">
	<div class="ui container">
		<div class="ui segment">
			<div class="ui grid middle aligned">
				<div class="sixteen wide mobile seven wide tablet seven wide computer column">
					<h3 class="font-bold margin-bottom half">Interested in our platform updates and promos?</h3>
					We'll notify you and promise never to spam.
				</div>
				<div class="sixteen wide mobile nine wide tablet nine wide computer column">
					<form method="POST" class="ui form has-loader" id="subscriptionForm" action="{{ route('manager.subscribe') }}">
						{{csrf_field()}}
						<div class="two fields no-margin-bottom">
							<div class="field">
								<div class="ui input">
								  	<input type="text" name="full_name" placeholder="Full Name">
								</div>
							</div>
							<div class="field">
								<div class="ui input">
								  	<input type="email" name="email" placeholder="Email">
								</div>
							</div>
							<button class="ui circular primary button has-loader-button" type="submit">Subscribe</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="feedbacks">
	<div class="ui stackable grid container">
		<div class="sixteen wide mobile eight wide tablet eight wide computer column"></div>
		<div class="sixteen wide mobile six wide tablet six wide computer column text-center">
			<div class="ui basic card label pointing below fluid font-regular font-size-normal">
				<div class="content">
				<p class="font-light">
					For a start-up online store like ours, Cloudstore offered convenient packages suitable for our company's needs. The platform is fast and secure, and its business tools efficiently helped us monitor the performance of our store. Great job! Keep it up!
				</p>
				</div>
			</div>
			<img class="ui tiny circular image inline" src="{{ asset('images/feedback1.jpg') }}">
			<p><strong>Jeff de Jesus, Ennoble</strong></p>
		</div>
	</div>
<!-- 

	<div class="ui stackable grid container">
		<div class="sixteen wide mobile two wide tablet two wide computer column"></div>
		<div class="sixteen wide mobile six wide tablet six wide computer column text-center">
			<div class="ui basic card label pointing below fluid font-regular font-size-normal">
				<div class="content">
				<p class="font-light">
					For a start-up online store like ours, Cloudstore offered convenient packages suitable for our company's needs. The platform is fast and secure, and its business tools efficiently helped us monitor the performance of our store. Great job! Keep it up!
				</p>
				</div>
			</div>
			<img class="ui tiny circular image inline" src="{{ asset('images/feedback1.jpg') }}">
			<p><strong>Jeff de Jesus, Ennoble</strong></p>
		</div>
	</div>


	<div class="ui stackable grid container">
		<div class="sixteen wide mobile nine wide tablet nine wide computer column"></div>
		<div class="sixteen wide mobile six wide tablet six wide computer column text-center">
			<div class="ui basic card label pointing below fluid font-regular font-size-normal">
				<div class="content">
				<p class="font-light">
					For a start-up online store like ours, Cloudstore offered convenient packages suitable for our company's needs. The platform is fast and secure, and its business tools efficiently helped us monitor the performance of our store. Great job! Keep it up!
				</p>
				</div>
			</div>
			<img class="ui tiny circular image inline" src="{{ asset('images/feedback1.jpg') }}">
			<p><strong>Jeff de Jesus, Ennoble</strong></p>
		</div>
	</div> -->
</div>


<div id="get-started">
	<div class="ui container text-center">
		<div class="font-massive font-regular margin-bottom">Ready to sell online?</div>
		<a href="{{ route('auth.login.form') }}" class="ui circular primary large button margin-top">Get started</a>
	</div>
</div>
@stop

@section('scripts')
<script>
$(document).ready(function(){
	$('#subscriptionForm')
		.form({
		fields: {
			full_name 	: 'empty',
			email 		: ['empty', 'email'],
		}
	});
});
</script>
@stop
