@extends($storeTheme.'.layout')

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
	<h2>Checkout</h2>
	<div class="ui grid">
		@if( Helpers::cartTotalItems() > 0 )
		<div class="sixteen wide mobile ten wide tablet ten wide computer column no-padding-top">
			<form class="ui form" id="checkoutForm" method="POST" action="/checkout/store">
				{{ csrf_field() }}
				<!-- Shipping Address -->
				<div class="ui segment">
					<h3 class="ui header">Shipping Address</h3>
					<div class="two fields">
						<div class="field">
							<label class="required">First Name</label>
							<input type="text" name="first_name" placeholder="First Name" @if( Auth::guest() ) value="{{ old('first_name') }}" @else value="{{ Auth::user()->first_name }}" readonly @endif>
						</div>
						<div class="field">
							<label class="required">Last Name</label>
							<input type="text" name="last_name" placeholder="Last Name" @if( Auth::guest() ) value="{{ old('last_name') }}" @else value="{{ Auth::user()->last_name }}" readonly @endif>
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
							<label class="required">ZIP Code</label>
							<input type="tel" name="zip" placeholder="ZIP Code" @if( Auth::guest() ) value="{{ old('zip') }}" @else value="{{ Auth::user()->zip }}" @endif>
						</div>
						<div class="field">
							<label class="required">Mobile Number</label>
							<input type="tel" name="phone" placeholder="Mobile Number" @if( Auth::guest() ) value="{{ old('phone') }}" @else value="{{ Auth::user()->phone }}" @endif>
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
					<div class="ui checkbox">
			        	<input type="checkbox" name="update_address" tabindex="0" class="hidden">
			        	<label>Update address</label>
				    </div>
					@endif
				</div>
				
				<!-- Shipping Methods -->
				<div class="ui segment">
					<h3 class="ui header">Shipping Methods</h3>
					@if( count($store->shipping_methods) > 0 )
					<div class="field margin-top">
						<div class="ui radio checkbox">
				        	<input type="radio" checked name="shipping_method" data-surcharge="{{ $store->shipping_methods[0]->surcharge }}" value="{{ $store->shipping_methods[0]->id }}" tabindex="0" class="hidden">
				        	<label>
				        		<strong>{{ $store->shipping_methods[0]->title }}</strong> <br />
				        		<p>{!! nl2br($store->shipping_methods[0]->description) !!}</p>
				        		Surcharge: {{ Helpers::currencyFormat($store->shipping_methods[0]->surcharge) }}
				        	</label>
				      	</div>
			      	</div>
			      	<?php $first = false; ?>
					@foreach( $store->shipping_methods as $shipping_method )
					<?php 
					if(! $first ) : 
				       $first = true;
				       continue;
				    endif;
					?>
					<div class="field margin-top">
						<div class="ui radio checkbox">
				        	<input type="radio" name="shipping_method" data-surcharge="{{ $shipping_method->surcharge }}" value="{{ $shipping_method->id }}" tabindex="0" class="hidden">
				        	<label>
				        		<strong>{{ $shipping_method->title }}</strong> <br />
				        		<p>{!! nl2br($shipping_method->description) !!}</p>
				        		Surcharge: {{ Helpers::currencyFormat($shipping_method->surcharge) }}
				        	</label>
				      	</div>
			      	</div>
			      	@endforeach
			      	@endif
				</div>


				<!-- Payment Methods -->
				<div class="ui segment">
					<h3 class="ui header">Payment Methods</h3>
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
				<input type="hidden" name="voucher_code">
			</form>
		</div>

		<div class="sixteen wide mobile six wide tablet six wide computer column">
			<div class="ui segments">
				<div class="ui segment">
					<h3 class="ui header">Order Summary</h3>
					<table class="ui very basic table no-border">
						<tbody>
							<?php $total = 0; ?>
							@foreach( $cart as $item )
					  		<?php $product = App\Product::findOrFail($item['id']); ?>
					  		<?php $price = $product->discounted_price ? $product->discounted_price : $product->price; ?>
					  		<tr class="top aligned">
					  			<td>
					  				<strong>{{ $product->title }}</strong><br />
					  				Quantity: {{ $item['quantity'] }}
					  			</td>
					  			<td class="right aligned">
					  				{{ Helpers::currencyFormat($price * $item['quantity']) }}
					  			</td>
					  		</tr>
					  		<?php $total += $item['quantity'] * $price;  ?>
					  		@endforeach
						</tbody>
					</table>
				</div>
				<form class="ui form" id="voucher_form" onsubmit="return false;">
					Got a voucher code? <a href="javascript:void(0)">Apply here</a>
					<div>
						<div class="field">
							<div class="ui action icon input loading fluid small">
							  	<input type="text" name="voucher_code" placeholder="Voucher code" autocomplete="off">
							  	<button class="ui button small" type="submit">Apply</button>
							</div>
							<div id="voucher_error"></div>
						</div>
					</div>
				</form>
				<div class="ui secondary segment">
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
					  					{{ Helpers::cartTotalAmount() }}<br />
					  					<span id="shipping_fee">{{ Helpers::currencyFormat($store->shipping_methods[0]->surcharge) }}</span><br />
					  					<strong class="voucher_text" id="voucher_discount_amount"></strong>
					  				</p>
					  			</td>
					  		</tr>
							<tr class="top aligned">
								<td><span class="font-bold font-medium">Total</span></td>
					  			<td class="right aligned">
					  				<span id="checkout_total" class="font-bold font-medium">{{ Helpers::currencyFormat( $total + $store->shipping_methods[0]->surcharge ) }}</span>
					  			</td>
							</tr>
						</tbody>
					</table>
					<button type="button" class="ui button primary large fluid" id="place_order_btn"><i class="icon lock"></i>Place Order</button>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
@stop

@section('scripts')
@if( Helpers::cartTotalItems() > 0 )
<script>
$('#checkoutForm')
.form({
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
var checkout_total = {{ $total }};

$('input[name=shipping_method]').change(function(){
	var surcharge = $(this).data('surcharge');
	$('#shipping_fee').text('₱ ' + surcharge.toFixed(2));
	$('#checkout_total').text('₱ ' + (parseFloat(checkout_total) + parseFloat(surcharge)).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
});


$('#place_order_btn').click(function(){
	$('#checkoutForm').submit();
});



$('#voucher_form a').click(function(){
	$('#voucher_form > div').show();
});


$('#voucher_form')
.form({
fields: {
	voucher_code	: 'empty',
}
});


$('#voucher_form button').click(function(){
	var $this = $(this);
	if( $('#voucher_form').form('is valid') && !$this.hasClass('clicked') ){
	    var html = $this.html();
		$this.addClass('clicked');
	    $this.html('<div class="ui active inline loader mini"></div>');
		var voucher_code = $this.parent().find('input').val();
		$.post('/validate_voucher',
            {
                voucher_code: voucher_code,
            },
            function(data){
            	var response = JSON.parse(data);
            	console.log(response);
            	if( response.success )
            	{
            		$('#voucher_form, #voucher_form > div').hide();
            		var surcharge = $('input[name=shipping_method]:checked').data('surcharge');
            		$('#voucher_error').text('');
            		$('#voucher_discount_amount').text(response.discount_format);
            		$('.voucher_text').show();
            		$('#checkoutForm input[name=voucher_code]').val(voucher_code);
					$('#checkout_total').text('₱ ' + (parseFloat(checkout_total) + parseFloat(surcharge) - response.discount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
					$this.parent().find('input').val('');
            	} else if( response.error )
            	{
            		$('.voucher_text').hide();
            		$('#voucher_discount_amount').text('');
            		$('#voucher_error').text(response.message);
            	}
            	$this.removeClass('clicked');
            	$this.html(html);
            }
        );
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