@extends($storeTheme.'.layout')
<?php $cartTotalAmount = Helpers::cartTotalAmount($store); ?>

@section('title')
<title>Checkout &rsaquo; {{ $store->name }}</title>
@stop

@section('content')
<div class="ui container margin-top">
	@if ( $errors->any() )
	<div class="ui grid">
		<div class="sixteen wide mobile ten wide tablet ten wide computer column no-padding-top no-padding-bottom">
			<div class="ui error small message">
			  	<ul class="list">
		        	@foreach( $errors->all() as $error )
		        	<li>{!! $error !!}</li>
		        	@endforeach
			  	</ul>
			</div>
		</div>
	</div>
    @endif
	<h2 class="margin-bottom half">Checkout</h2>
	<div class="ui mobile stackable steps no-margin-top">
	  	<a class="active step step_1_button" id="step-step-1">
		    <div class="content">
		      	<div class="title">Shipping</div>
		      	<div class="description">Enter shipping details</div>
		    </div>
	  	</a>
	  	<a class="step continue_button" id="step-step-2">
		    <div class="content">
		      	<div class="title">Payment</div>
		      	<div class="description">Choose your payment method</div>
		    </div>
	  	</a>
	</div>

	<form class="ui form" id="checkoutForm" method="POST" action="/checkout/store">
		{{ csrf_field() }}
		<div class="ui grid">
			@if( Helpers::cartTotalItems($store) > 0 )
			<div class="sixteen wide mobile ten wide tablet ten wide computer column no-padding-top">
				<!-- Step 1 -->
				<div class="checkout-step show margin-top" id="step1">
					<!-- Shipping Address -->
					<div class="ui segment">
						<h3 class="ui header">Shipping address</h3>
						<div class="two fields">
							<div class="field">
								<label class="required">First name</label>
								<input type="text" name="first_name" placeholder="First name" @if( Auth::guest() ) value="{{ old('first_name') }}" @else value="{{ Auth::user()->first_name }}" readonly @endif>
							</div>
							<div class="field">
								<label class="required">Last name</label>
								<input type="text" name="last_name" placeholder="Last name" @if( Auth::guest() ) value="{{ old('last_name') }}" @else value="{{ Auth::user()->last_name }}" readonly @endif>
							</div>
						</div>
						<div class="field">
							<label class="required">Street</label>
							<input type="text" name="street" placeholder="Street" @if( Auth::guest() ) value="{{ old('street') }}" @else value="{{ Auth::user()->street }}" @endif>
						</div>
						<div class="two fields">
							<div class="field">
								<label class="required">City</label>
								<input type="text" name="city" placeholder="City" @if( Auth::guest() ) value="{{ old('city') }}" @else value="{{ Auth::user()->city }}" @endif>
							</div>
							<div class="field">
								<label class="required">Province</label>
								<input type="text" name="province" placeholder="Province" @if( Auth::guest() ) value="{{ old('province') }}" @else value="{{ Auth::user()->province }}" @endif>
							</div>
						</div>
						<div class="two fields">
							<div class="field">
								<label class="required">ZIP code</label>
								<input type="tel" name="zip" placeholder="ZIP code" @if( Auth::guest() ) value="{{ old('zip') }}" @else value="{{ Auth::user()->zip }}" @endif>
							</div>
							<div class="field">
								<label class="required">Mobile number</label>
								<input type="tel" name="phone" placeholder="Mobile number" @if( Auth::guest() ) value="{{ old('phone') }}" @else value="{{ Auth::user()->phone }}" @endif>
							</div>
						</div>
						
						@if( Auth::guest() )
						<hr />
						<p>
							We will create an account for you so you can track your order and view your order history. <br />
							<span class="text-grey">Already registered?</span> <a class="login_btn">Login here</a>
						</p>
						<div class="two fields">
							<div class="field">
								<label class="required">Email</label>
								<input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
							</div>
							<div class="field">
								<label class="required">Password</label>
								<input type="password" name="password" placeholder="Password	">
							</div>
						</div>
						@else
						<input type="text" name="email" placeholder="Email" value="{{ Auth::user()->email }}">
						<div class="ui checkbox">
				        	<input type="checkbox" name="update_address" tabindex="0" class="hidden">
				        	<label>Update address</label>
					    </div>
						@endif
					</div>
					<!-- Shipping Methods -->
					<div class="ui segment">
						<h3 class="ui header">Shipping methods</h3>
						@if( $store->shipping_methods->count() > 0 )
				      	<?php $first = true; ?>
						@foreach( $store->shipping_methods as $shipping_method )
						@if( $shipping_method->rates->count() > 0 )
						<div class="field margin-top">
							<div class="ui radio checkbox">
					        	<input type="radio" @if( $first ) checked @endif name="shipping_method" data-rates="{{ json_encode($shipping_method->rates) }}" value="{{ $shipping_method->id }}" tabindex="0" class="hidden">
					        	<label><strong>{{ $shipping_method->title }}</strong></label>
					      	</div>

							<table class="ui compact very basic table no-margin-top no-border shipping-rates-table">
							  	<tbody>
					        		@foreach( $shipping_method->rates as $rate )
								    <tr>
								      	<td>{{ number_format($rate->min, 2) }} kg - {{ number_format($rate->max, 2) }} kg</td>
								      	<td>{{ Helpers::currencyFormat($rate->rate) }}</td>
								    </tr>
					        		@endforeach
							  	</tbody>
							</table>
				      	</div>
						<?php if( $first ) $first = false; ?>
				      	@endif
				      	@endforeach
				      	@endif
					</div>
				</div>
				
				<!-- Step 2 -->
				<div class="checkout-step margin-top" id="step2">
					<!-- Payment Methods -->
					<div class="ui segment">
						<h3 class="ui header">Payment modes</h3>
						@if( count($store->payment_modes) > 0 )
						<div class="field margin-top">
							<div class="ui radio checkbox">
					        	<input type="radio" checked name="payment_mode" value="{{ $store->payment_modes[0]->id }}" tabindex="0" class="hidden">
					        	<label>
					        		<strong>{{ $store->payment_modes[0]->title }}</strong> <br />
					        		<p>{!! nl2br($store->payment_modes[0]->description) !!}</p>
					        	</label>
					      	</div>
				      	</div>
				      	<?php unset($store->payment_modes[0]); ?>
						@foreach( $store->payment_modes as $payment_mode )
						<div class="field margin-top">
							<div class="ui radio checkbox">
					        	<input type="radio" name="payment_mode" value="{{ $payment_mode->id }}" tabindex="0" class="hidden">
					        	<label>
					        		<strong>{{ $payment_mode->title }}</strong> <br />
					        		<p>{!! nl2br($payment_mode->description) !!}</p>
					        	</label>
					      	</div>
				      	</div>
				      	@endforeach
				      	@endif
					</div>

					<!-- Notes -->
					<div class="ui segment">
						<h3 class="ui header no-margin-bottom">Notes to seller (optional)</h3>
						<small>Max 255 characters</small>
						<textarea name="notes" class="margin-top" placeholder="Write something to the seller" maxlength="255" rows="4"></textarea>
					</div>
					<a href="javascript:void()" class="font-small step_1_button">Edit shipping</a>
					<input type="hidden" name="voucher_code">
				</div>
			</div>

			<div class="sixteen wide mobile six wide tablet six wide computer column">
				<div class="ui segments">
					<div class="ui segment">
						<h3 class="ui header">Order Summary</h3>
						<div class="table-responsive borderless">
							<table class="ui very basic compact unstackable table no-border">
								<tbody>
									<?php $total = $weight = 0; ?>
									@foreach( $cart as $item )
							  		<?php $product = App\Product::findOrFail($item['id']); ?>
							  		<?php if( $product ) : ?>
							  		<tr class="top aligned">
							  			<td>
							  				<strong>{{ $product->title }}</strong><br />
								  			<small class="text-grey">{{ number_format($product->weight, 2) }} kg</small>
							  			</td>
							  			<td><small class="text-grey">x {{ $item['quantity'] }}</small></td>
							  			<td class="right aligned">
							  				{{ Helpers::currencyFormat($product->price * $item['quantity']) }}
							  			</td>
							  		</tr>
							  		<?php 
							  		endif;
							  		$total += $item['quantity'] * $product->price;  
							  		$weight += $product->weight;  
							  		?>
							  		@endforeach
								</tbody>
							</table>
						</div>
						<div>Total weight: {{ number_format($weight, 2) }} kg</div>
					</div>
					<div id="voucher_form">
						Got a voucher code? <a href="javascript:void(0)">Apply here</a>
						<div>
							<div class="field">
								<div class="ui action icon input loading fluid small">
								  	<input type="text" name="validate_voucher_code" placeholder="Voucher code" autocomplete="off">
								  	<button class="ui button small" type="button">Apply</button>
								</div>
								<div id="voucher_error"></div>
							</div>
						</div>
					</div>
					<div class="ui secondary segment">
						<?php $initialShippingRate = Helpers::initialShippingRate($store, $weight); ?>
						<input type="hidden" id="shipping_rate" value="{{ number_format($initialShippingRate, 2) }}">
						<table class="ui very basic condensed table no-border no-margin-top">
							<tbody>
								<tr class="top aligned">
						  			<td class="no-padding-top">
						  				<p>
						  					Subtotal<br />Shipping fee<br />
						  					<strong class="voucher_text">Voucher <i class="fa fa-close" title="Remove"></i></strong>
						  				</p>
						  			</td>
						  			<td class="right aligned no-padding-top">
						  				<p>
						  					{{ $cartTotalAmount }}<br />
						  					<span id="shipping_fee">{{ Helpers::currencyFormat($initialShippingRate) }}</span><br />
						  					<strong class="voucher_text" id="voucher_discount_amount"></strong>
						  				</p>
						  			</td>
						  		</tr>
								<tr class="top aligned">
									<td><span class="font-weight-medium font-medium">Total</span></td>
						  			<td class="right aligned">
						  				<span id="checkout_total" class="font-weight-medium font-medium">{{ Helpers::currencyFormat( $total + $initialShippingRate ) }}</span>
						  			</td>
								</tr>
							</tbody>
						</table>
						<button type="button" class="ui button primary large right floated continue_button">Continue</button>
						<button type="submit" class="ui button primary large right floated" id="place_order_button"><i class="icon lock"></i>Place Order</button>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			@endif
		</div>
	</form>
</div>
@stop

@section('scripts')
@if( Helpers::cartTotalItems($store) > 0 )
<script>
var checkoutForm = $('#checkoutForm');
checkoutForm.form({
fields: {
	email 			: ['empty', 'email'],
	password 		: 'empty',
	first_name 		: 'empty',
  	last_name 		: 'empty',
  	street 			: 'empty',
  	city 			: 'empty',
  	province 		: 'empty',
  	zip 	        : ['empty', 'number'],
  	phone		 	: ['empty', 'number'],
  	shipping_method : ['checked', 'number'],
  	payment_mode  : ['checked', 'number'],
}
});


function step1Event(){
	$('html, body').animate({scrollTop: '0px'}, 0);
	$('.checkout-step').removeClass('show');
	$('#step1').addClass('show');
	$('.step').removeClass('active');
	$('#step-step-1').addClass('active');
	$('#voucher_form').hide();
	$('#place_order_button').hide();
	$('button.continue_button').show();
}

function step2Event(){
	checkoutForm.form('validate form');
	if( checkoutForm.form('is valid') ){
		$('html, body').animate({scrollTop: '0px'}, 0);
		$('.checkout-step').removeClass('show');
		$('#step2').addClass('show');
		$('.step').removeClass('active');
		$('#step-step-2').addClass('active');
		$('#voucher_form').show();
		$('#place_order_button').show();
		$('button.continue_button').hide();
	}
}

$('.step_1_button').click(function(){
	step1Event();
});

$('.continue_button').click(function(){
	step2Event();
});

checkoutForm.on('submit', function(e){
	if( !$('#step2').hasClass('show') ){
		step2Event();
		e.preventDefault();
	}
});

var checkout_total = {{ $total }};

$('input[name=shipping_method]').change(function(){
	var weight = {{ $weight }};
	var rates = $(this).data('rates');
	var rate = 0;
	for( var i = 0; i < rates.length; i++ ){
		if( weight >= rates[i].min && weight <= rates[i].max ){
			rate = rates[i].rate;
			break;
		}
	}
	$('#shipping_rate').val(parseFloat(rate).toFixed(2));
	$('#shipping_fee').text('₱' + parseFloat(rate).toFixed(2));
	$('#checkout_total').text('₱' + (parseFloat(checkout_total) + parseFloat(rate)).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
});



$('#voucher_form a').click(function(){
	$('#voucher_form > div').show();
});



$('#voucher_form button').click(function(){
	var voucher_code = $('#voucher_form input[name=validate_voucher_code]').val().trim();
	var $this = $(this);
	if( voucher_code.length > 0  ){
		if( !$(this).hasClass('clicked') ){
			$(this).addClass('clicked loading');
			$.post('/ajax_validate_voucher',
	            {
	                voucher_code: voucher_code,
	                email: $('input[name=email]').val().trim(),
	            },
	            function(data){
	            	//console.log(data);
	            	var response = JSON.parse(data);
	            	if( response.success )
	            	{
	            		$('#voucher_form, #voucher_form > div').hide();
	            		var shipping_rate = $('#shipping_rate').val();
	            		$('#voucher_error').text('');
	            		$('#voucher_discount_amount').text(response.discount_format);
	            		$('.voucher_text').show();
	            		$('#checkoutForm input[name=voucher_code]').val(voucher_code);
						$('#checkout_total').text('₱ ' + (parseFloat(checkout_total) + parseFloat(shipping_rate) - response.discount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
						$this.parent().find('input').val('');
	            	} else if( response.error )
	            	{
	            		$('.voucher_text').hide();
	            		$('#voucher_discount_amount').text('');
	            		$('#voucher_error').text(response.message);
	            	}
	            	$this.removeClass('clicked loading');
	            }
	        );
		}
	} else {
		$(this).closest('.field').addClass('error');
	}
});
$('.voucher_text .fa').click(function(){
    $('#voucher_form').show();
	var surcharge = $('input[name=shipping_method]:checked').data('surcharge');
	$('#checkout_total').text('₱ ' + (parseFloat(checkout_total) + parseFloat(surcharge)).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	$('.voucher_text').hide();
	$('#voucher_discount_amount').text('');
    $('#checkoutForm input[name=voucher_code]').val('');
});
</script>
@endif
@stop