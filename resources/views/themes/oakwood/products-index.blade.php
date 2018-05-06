@extends($storeTheme.'.layout')

@section('title')
<title>{{ $category }} &rsaquo; {{ $store->name }}</title>
@stop

@section('content')
<div class="ui container margin-top">
	@if( $store->products->where('is_featured', true)->count() > 0 )
	<div class="ui four stackable cards">
		@foreach( $products as $product )
    	<div class="ui fluid card product-card">
      		<div class="image">
	      		<a href="{{ $product->url }}" class="product-image" @if( $product->product_images->count() > 0 ) style="background-image:url({{ Helpers::getImage($product->product_images[0]->image) }})" @endif title="{{ $product->title }}"">
	      		</a>
	      	</div>
	      	<div class="content">
	        	<a class="header" href="{{ $product->url }}">{{ $product->title }}</a>
		      	<div class="description">
		      		{{ str_limit( $product->description, 100 ) }}
		      	</div>
		      	<div class="description margin-top">
		      		<strong>
		      		@if( $product->discounted_price ) 
		      		{{ Helpers::currencyFormat($product->discounted_price) }} 
		      		<del class="font-regular">{{ Helpers::currencyFormat($product->price) }}</del>
		      		{!! Helpers::getDiscountHTML($product->price, $product->discounted_price) !!} 
					@else
		      		{{ Helpers::currencyFormat($product->price) }} 
		      		@endif
		      		</strong>
		      	</div>
	      	</div>
		    <!-- <div class="ui bottom attached blue button add_to_cart" data-id="{{ $product->id }}" data-message="Added to cart">
		      	<i class="cart icon"></i>
		      	Add to cart
		    </div> -->
    	</div>
		@endforeach
	</div>
	@endif
</div>
@stop