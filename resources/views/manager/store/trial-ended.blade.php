@extends('manager.layout')

@section('body-class')
"body-dimmed"
@stop

@section('title')
<title>Trial ended for {{ $store->name }} &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')

<div class="ui container">
	<div class="ui grid stackable margin-top full-height">
		<div class="sixteen wide mobile one wide tablet two wide computer column"></div>
		<div class="sixteen wide mobile fourteen wide tablet twelve wide computer column">
			<div class="text-center margin-bottom">
				<h2 class="font-medium font-massive margin-bottom half">Your free trial has ended</h2>
				@if( $invoice )
				<p>An invoice has already been generated for this store. Please settle your balance to regain access.</p>
				@else
				<p>Don’t worry, your store is safe and you can easily regain access by picking a plan below.</p>
				@endif
			</div>
			<br />
			@if( $invoice )
			<br />
			<div class="text-center margin-bottom">
				<a class="ui button big primary" href="{{ route('manager.invoice.show', $invoice->id) }}">View invoice</a>
			</div>
			@else
			<form class="ui form" id="pickPlanForm" method="POST" action="{{ route('manager.invoice.store') }}">
				{{ csrf_field() }}
				<input type="hidden" name="store_id" value="{{ $store->id }}">
				<!-- Step 2 -->
				<div class="content-step show" id="content-step2">
					<div class="ui stackable three cards field no-margin-bottom">
						@foreach( App\Plan::orderBy('price', 'asc')->get() as $plan )
						<div class="card text-center card-plan">
						    <div class="content">
						      <div class="header">
						      	{{ $plan->plan }}
						      	<div>
						      		<div class="pricing-plan-price small"><span>₱{{ number_format($plan->price) }} <small>/month</small></span></div>
						      	</div>
						      </div>
						    </div>
							<div class="content">
									<div class="ui radio checkbox">
										<input type="radio" name="plan_id" data-plan="{{ $plan->plan }}" value="{{ $plan->id }}" @if( old('plan_id') == $plan->id ) checked @endif>
									<label class="font-regular cursor pointer">Select this plan</label>
								</div>
							</div>
						</div>
						@endforeach
					</div>
					<a href="{{ route('manager.pricing') }}" target="_blank" class="font-small">View pricing and features</a>
					<button type="button" id="nextStep2" class="ui right labeled icon primary large circular button right floated next-button margin-top">Billing info <i class="chevron right icon"></i></button>
					<div class="clearfix"></div>
				</div>

				<!-- Step 3 -->
				<div class="content-step" id="content-step3">
					<h3 class="font-thin font-medium margin-bottom">Billing information</h3>
					<div class="margin-bottom">
						<div class="two fields">
							<div class="field">
								<label class="required">First Name</label>
								<input type="text" value="{{ Auth::user()->first_name }}" readonly>
							</div>
							<div class="field">
								<label class="required">Last Name</label>
								<input type="text" value="{{ Auth::user()->last_name }}" readonly>
							</div>
						</div>
						<div class="field">
							<label class="required">Street</label>
							<input type="text" value="{{ Auth::user()->street }}" name="street">
						</div>
						<div class="two fields">
							<div class="field">
								<label class="required">City</label>
								<input type="text" value="{{ Auth::user()->city }}" name="city">
							</div>
							<div class="field">
								<label class="required">Province</label>
								<input type="text" value="{{ Auth::user()->province }}" name="province">
							</div>
						</div>
						<div class="two fields">
							<div class="field">
								<label class="required">ZIP Code</label>
								<input type="text" value="{{ Auth::user()->zip }}" name="zip">
							</div>
							<div class="field">
								<label class="required">Mobile Number</label>
								<input type="text" value="{{ Auth::user()->phone }}" name="phone">
							</div>
						</div>
						<div class="field">
							<div class="ui checkbox">
					        	<input type="checkbox" name="update_address" value="update_address" id="update_address" tabindex="0" class="hidden">
					        	<label>Update address</label>
						    </div>
					    </div>
					</div>

					<div class="margin-bottom">&nbsp;</div>

					<button type="button" id="backStep2" class="ui circular labeled icon button large">Back <i class="chevron left icon"></i></button>
					<button type="button" id="buttonCreateStore" class="ui circular primary large button right floated">Submit order</button>
					<div class="clearfix"></div>
				</div>
			</form>
			@endif

		</div>
	</div>
</div>
@stop

@section('scripts')
<script>
	var pickPlanForm = $('#pickPlanForm');

	function step2Validation(){
		var fields = {
		  	plan_id : 'checked',
		};
		pickPlanForm.form({ fields: fields });
	}
	function step2Event(){
		var subdomain = $('#subdomain').val();
		if ( pickPlanForm.form('is valid') ) {
			$('html, body').animate({scrollTop: '0px'}, 0);
			$('.content-step').removeClass('show');
			$('#content-step3').addClass('show');
		}
	}
	step2Validation();


	function step3Validation(){
		var fields = {
		  	plan_id 			: 'checked',
		  	street 				: 'empty',
		  	city 				: 'empty',
		  	province 			: 'empty',
		  	zip 	        	: ['empty', 'number'],
		  	phone  				: ['empty', 'number', 'maxLength[11]', 'regExp[/^$|^(09|){2}\\d{9}$/]'],
		};
		pickPlanForm.form({ fields: fields });
	}
	function step3Event(fields){
		if ( pickPlanForm.form('is valid')) {
			return true;
		}
		return false;
	}

	$('#nextStep2').click(function(){
		pickPlanForm.form('validate form');
		step2Event();
	});

	$('#backStep2').click(function(){
		step2Validation();
		pickPlanForm.form('validate form');
		$('html, body').animate({scrollTop: '0px'}, 0);
		$('.step').removeClass('active');
		$('#step2').addClass('active');
		$('.content-step').removeClass('show');
		$('#content-step2').addClass('show');
	});

	$('#buttonCreateStore').click(function(){
		pickPlanForm.submit();
	});

	pickPlanForm.on('submit', function(e){
		var step_id = $('.content-step.show').attr('id');
		if( step_id != "content-step3" ){
			$('.content-step.show').find('.next-button').click();
			e.preventDefault();
			return false;
		}
		step3Validation();
		pickPlanForm.form('validate form');
		var success = step3Event();
		if( !success ) {
			e.preventDefault();
			return false;
		}
	});
</script>
@stop