@extends($storeTheme.'.layout')

@section('title')
<title>{{ $product->title }} &rsaquo; {{ $store->name }}</title>
@stop

@section('meta_tags')
<meta property="fb:app_id" 			content="1208410692601134" /> 
<meta property="og:type"   			content="product" /> 
<meta property="og:url"    			content="{{ Request::url() }}" /> 
<meta property="og:title"  			content="{{ $product->title }}" /> 
<meta property="og:description"  	content="{{ $product->description }}" /> 
<meta property="og:image"  @if( count($product->product_images ) > 0 ) content="{{ url('') . Helpers::getImage($product->product_images[0]->image) }}" @endif /> 
@stop

@section('content')
<div class="ui container margin-top">
	<div class="ui grid stackable">
		<div class="ten wide tablet ten wide computer column">
			<div class="text-center margin-bottom" id="product-gallery-image">
				@if( count($product->product_images ) > 0 )
				<img src="{{ Helpers::getImage($product->product_images[0]->image) }}">
				@endif
			</div>
			<div class="product-image-previews">
				@if( count($product->product_images ) > 0 )
				<div class="product-image-preview active" data-src="{{ Helpers::getImage($product->product_images[0]->image) }}">
					<div style="background-image: url({{ Helpers::getImage($product->product_images[0]->image) }})"></div>
				</div>
				<?php unset($product->product_images[0]); ?>
				@foreach( $product->product_images as $product_image )
				<div class="product-image-preview" data-src="{{ Helpers::getImage($product_image->image) }}">
					<div style="background-image: url({{ Helpers::getImage($product_image->image) }})"></div>
				</div>
				@endforeach
				@endif
			</div>
		</div>
		<div class="six wide tablet six wide computer column">
			<h1>{{ $product->title }}</h1>
			<span class="font-medium">
	      		@if( $product->discounted_price ) 
	      		{{ Helpers::currencyFormat($product->discounted_price) }} 
				@else
	      		{{ Helpers::currencyFormat($product->price) }} 
	      		@endif
			</span>

      		@if( $product->discounted_price ) 
      		<div>
      			<del class="font-regular">{{ Helpers::currencyFormat($product->price) }}</del>
      			{!! Helpers::getDiscountHTML($product->price, $product->discounted_price) !!} 
      		</div>
      		@endif
      		<p class="margin-top">{!! nl2br($product->description) !!}</p>
      		<button type="button" class="ui button primary add_to_cart" id="product_add_to_cart"  data-id="{{ $product->id }}" data-message="Added to cart"><i class="cart icon"></i>Add to cart</button>

      		<p class="margin-top">
      			<strong>Payment Modes</strong> <br />
      			@foreach( $store->payment_modes as $payment_mode )
      			{{ $payment_mode->title }}<br />
      			@endforeach
      		</p>

      		<p class="margin-top">
      			<strong>Shipping Methods</strong> <br />
      			@foreach( $store->shipping_methods as $shipping_method )
      			{{ $shipping_method->title }}<br />
      			@endforeach
      		</p>
		</div>
	</div>
</div>
@stop

@section('scripts')
<script>
jQuery(document).ready(function(){
	$('.product-image-preview').click(function(){
		if( !$(this).hasClass('active') )
		{
			var src = $(this).data('src');
			$('.product-image-preview').removeClass('active');
			$(this).addClass('active');
			$('#product-gallery-image img').attr('src', src);
		}
	});
});
</script>
@stop