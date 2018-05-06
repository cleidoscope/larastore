@extends($storeTheme.'.layout')

@section('title')
<title>{{ $category }} &rsaquo; {{ $store->name }}</title>
@stop

@section('content')
<div class="ui container margin-top">
	
	<h3 class="font-big font-montserrat">{{ $category }}</h3>
	@if( count($products) > 0 )
	<div class="ui four stackable cards">
		@foreach( $products as $product )
    	<div class="ui fluid card product-card">
      		<div class="image">
	      		<a href="{{ $product->url }}" class="product-image" @if( $product->product_images->count() > 0 ) style="background-image:url({{ Helpers::getImage($product->product_images[0]->image) }})" @endif title="{{ $product->title }}"">
	      		</a>
	      	</div>
	      	<div class="content">
	        	<a class="header" href="{{ $product->url }}">{{ $product->title }}</a>
	        	<div class="margin-bottom half">
	        		@if( $product->product_reviews->where('is_approved', true)->count() > 0 )
	        		{!! Helpers::getRatingsAverageStars($product) !!}
	        		<span class="text-grey">({{ $product->product_reviews->where('is_approved', true)->count() }} reviews)</span>
	        		@else
	        		<span class="text-grey">No reviews</span>
	        		@endif
	        	</div>
		      	<div class="description">
		      		{{ str_limit( $product->description, 90 ) }}
		      	</div>
		      	<div class="margin-top half">
		      		<strong>
		      		{{ Helpers::currencyFormat($product->price) }} 
		      		@if( $product->old_price ) 
		      		{!! Helpers::getDiscountHTML($product->price, $product->old_price) !!} 
		      		@endif
		      		</strong>
		      	</div>
	      	</div>
	      	@if( $product->in_stock )
		    <div class="ui bottom attached blue button add_to_cart" data-id="{{ $product->id }}" data-message="Added to cart">
		      	<i class="cart icon"></i>
		      	Add to cart
		    </div>
		    @else
		    <div class="ui bottom attached blue button disabled">
		      	Out of stock
		    </div>
		    @endif
    	</div>
		@endforeach
	</div>

	<div class="text-right margin-top"> 
	{!! $products->links($storeTheme.'.partials.pagination') !!}
	</div>
	<div class="clearfix"></div>
	@endif
</div>
@stop