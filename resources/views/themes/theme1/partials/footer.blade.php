@if( !$store->is_basic )
<div class="subscription text-center">
	<div class="ui container">
		<div class="ui segment">
			<h3 class="all-caps">Subscribe to our newsletter</h3>
			<div class="ui grid">
				<div class="sixteen wide mobile three wide tablet three wide computer column no-padding"></div>
				<div class="sixteen wide mobile ten wide tablet ten wide computer column">
					<form method="POST" class="ui form has-loader" id="subscriptionForm" action="/subscribe">
						{{csrf_field()}}
						<div class="two fields">
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
							<button class="ui button primary has-loader-button" type="submit">Subscribe</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endif

<div class="ui container text-center margin-top about-store">
	<h3 class="no-margin-bottom">{{ $store->name }}</h3>
	@if( $store->street ) <div>{{ $store->street }},</div>@endif
	@if( $store->city ) {{ $store->city }} @endif
	@if( $store->province ) , {{ $store->province }} @endif
	@if( $store->zip_code ) {{ $store->zip_code }} @endif
	@if( $store->phone ) <div>{{ $store->phone }}</div> @endif
	<div class="social-media"> 
	@if( !empty( $store->facebook ) ) <a href="https://www.facebook.com/{{ $store->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a> @endif
	@if( !empty( $store->twitter ) ) <a href="https://twitter.com/{{ $store->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a> @endif
	@if( !empty( $store->instagram ) ) <a href="https://www.instagram.com/{{ $store->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a> @endif
	</div>
</div>
<footer>
	<div class="ui container">
	Powered by&nbsp;&nbsp;<a href="{{ route('manager.homepage') }}" target="_blank"><img src="{{asset('logo.svg')}}" title="Cloudstore Philippines" alt="Cloudstore Philippines"></a>
	</div>
</footer>