@extends($storeTheme.'.layout')

@section('title')
<title>Shopping Cart &rsaquo; {{ $store->name }}</title>
@stop

@section('content')
<div class="ui container margin-top">
	<h2>Shopping Cart</h2>
	@if( Helpers::cartTotalItems($store) > 0 )
	<div class="ui grid stackable">
		<div class="eleven wide tablet eleven wide computer column">
			<table class="ui single line table cart-table">
			  	<thead>
				    <tr>
				    	<th>Product</th>
				    	<th>Quantity</th>
				    	<th>Total</th>
				    	<th></th>
				  	</tr>
			  	</thead>
			  	<tbody>
			  		@foreach( $cart as $item )
			  		<?php $product = App\Product::findOrFail($item['id']); ?>
				    <tr class="top aligned">
				      	<td>
					        <h4 class="ui image header">
					        	<a href="{{ $product->url }}" class="cart-product-thumb" @if( $product->product_images[0] )style="background-image: url({{ Helpers::getImage($product->product_images[0]->image) }})" @endif title="{{ $product->title }}"></a>
					          	<div class="content">
					            	<a href="{{ $product->url }}">{{ $product->title }}</a>
					            	<div class="sub header">
					            		Unit price:
							      		<strong>{{ Helpers::currencyFormat($product->price) }}</strong>
					            		@if( $product->old_price ) 
					            		<br />
							      		<del>{{ Helpers::currencyFormat($product->old_price) }}</del>
							      		<strong>{!! Helpers::getDiscountHTML($product->price, $product->old_price) !!}</strong>
										@else
							      		@endif
					            	</div>
					        	</div>
					      	</h4>
				      	</td>
				      	<td>
				      		<div class="ui small action input cart-quantity">
							  	<button class="ui icon button mini subtract_from_cart" data-id="{{ $product->id }}" data-message="Cart updated">
							  		<i class="minus icon"></i>
							  	</button>
							  	<input type="number" value="{{ $item['quantity'] }}" readonly class="product-quantity">
							  	<button class="ui icon button mini add_to_cart" data-id="{{ $product->id }}" data-message="Cart updated">
							    	<i class="plus icon"></i>
							  	</button>
							</div>
				      	</td>
				      	<td>
				      		<span id="product-total-{{ $product->id }}"> 
				      		@if( $product->discounted_price ) 
				      		{{ Helpers::currencyFormat($product->discounted_price * $item['quantity']) }}
				      		@else
				      		{{ Helpers::currencyFormat($product->price * $item['quantity']) }}
				      		@endif
				      		</span>
				      	</td>
				      	<td>
				      		<button class="circular ui icon red button mini remove_from_cart" data-id="{{ $product->id }}" data-message="Removed from cart">
							  	<i class="icon remove"></i>
							</button>
						</td>
				    </tr>
				    @endforeach
			    </tbody>
			</table>
		</div>

		<div class="five wide tablet five wide computer column">
			<div class="ui segment text-center">
				<div class="font-big">Cart Total</div>
				<div class="font-big font-weight-medium margin-top margin-bottom" id="cart_total">{{ Helpers::cartTotalAmount($store) }}</div>
				<div class="margin-top">&nbsp;</div>
				<a class="ui button primary large fluid" href="/checkout">Checkout</a>
			</div>
		</div>
	</div>
	@endif
</div>
@stop