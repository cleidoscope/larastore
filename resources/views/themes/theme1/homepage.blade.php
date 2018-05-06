@extends($storeTheme.'.layout')
<?php $carousels = $store->carousels; ?>

@section('title')
<title>{{ $store->name }}@if( $store->tagline ) - {{ $store->tagline }}@endif</title>
@stop

@if( count($carousels) > 0 )
@section('styles')
<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
@stop
@endif

@section('content')

@if( count($carousels) > 0 )
<div class="ui container">
	@if( $owner )
	@endif
	<div id="themeCarousel" class="carousel slide" data-ride="carousel">
	  	<ol class="carousel-indicators">
	  		<?php $first = true; $i = 0; ?>
	  		@foreach( $carousels as $carousel )
		    <li data-target="#themeCarousel" data-slide-to="{{ $i }}" @if( $first ) class="active" @endif></li>
		    <?php $first = false; $i++; ?>
		    @endforeach
	  	</ol>

	  	<div class="carousel-inner">
	  		<?php $first = true; ?>
	  		@foreach( $carousels as $carousel )
	  			@if( $carousel->url )
			    <a class="item @if( $first ) active @endif" href="{{ $carousel->url }}">
			      	<img src="{{ $carousel->image }}" width="100%">
			    </a>
			    @else
			    <div class="item @if( $first ) active @endif">
			    	<img src="{{ $carousel->image }}" width="100%">
			    </div>
			    @endif
		    <?php $first = false; ?>
		    @endforeach
	 	 </div>

	  	<!-- Left and right controls -->
	  	<a class="left carousel-control" href="#themeCarousel" data-slide="prev">
		    <i class="carousel-control-left fa fa-angle-left"></i>
	  	</a>
	  	<a class="right carousel-control" href="#themeCarousel" data-slide="next">
		    <i class="carousel-control-right fa fa-angle-right"></i>
	  	</a>
	</div>
</div>
@endif


<div class="ui container">
	@if( $store->products->where('is_featured', true)->count() > 0 )
	<h3 class="font-big font-montserrat">Featured Products</h3>
	<div class="ui four cards margin-top">
		<div class="owl-carousel owl-theme">
			@foreach( $store->products->where('is_featured', true) as $featured_product )
	    	<div class="ui fluid card product-card">
	      		<div class="image">
		      		<a href="{{ $featured_product->url }}" class="product-image" @if( $featured_product->product_images->count() > 0 ) style="background-image:url({{ Helpers::getImage($featured_product->product_images[0]->image) }})" @endif title="{{ $featured_product->title }}">
		      		</a>
		      	</div>
		      	<div class="content">
		        	<a class="header" href="{{ $featured_product->url }}">{{ $featured_product->title }}</a>
		        	<div class="margin-bottom half">
		        		@if( $featured_product->product_reviews->where('is_approved', true)->count() > 0 )
		        		{!! Helpers::getRatingsAverageStars($featured_product) !!}
		        		<span class="text-grey">({{ $featured_product->product_reviews->where('is_approved', true)->count() }} reviews)</span>
		        		@else
		        		<span class="text-grey">No reviews</span>
		        		@endif
		        	</div>
			      	<div class="description">
			      		{{ str_limit( $featured_product->description, 90 ) }}
			      	</div>
			      	<div class="margin-top half">
			      		<strong>
			      		{{ Helpers::currencyFormat($featured_product->price) }} 
			      		@if( $featured_product->old_price ) 
			      		{!! Helpers::getDiscountHTML($featured_product->price, $featured_product->old_price) !!} 
			      		@endif
			      		</strong>
			      	</div>
		      	</div>
		      	@if( $featured_product->in_stock )
			    <div class="ui bottom attached blue button add_to_cart" 
			    @if( $featured_product->discounted_price )
			    data-price="{{ $featured_product->discounted_price }} "
			    @else
			    data-price="{{ $featured_product->price }}"
	      		@endif 
			    data-id="{{ $featured_product->id }}" 
			    data-message="Added to cart">
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
	</div>
	@endif

	@if( $store->products->count() > 0 )
	<br />
	<br />
	<br />
	<h3 class="font-big font-bold font-montserrat text-right">Latest products</h3>
	<div class="ui four stackable cards margin-top margin-bottom">
		@foreach( $store->products->take(4) as $new_product )
    	<div class="ui fluid card product-card">
      		<div class="image">
	      		<a href="{{ $new_product->url }}" class="product-image" @if( $new_product->product_images->count() > 0 ) style="background-image:url({{ Helpers::getImage($new_product->product_images[0]->image) }})" @endif title="{{ $new_product->title }}">
	      		</a>
	      	</div>
	      	<div class="content">
	        	<a class="header" href="{{ $new_product->url }}">{{ $new_product->title }}</a>
	        	<div class="margin-bottom half">
	        		@if( $new_product->product_reviews->where('is_approved', true)->where('is_approved', true)->count() > 0 )
	        		{!! Helpers::getRatingsAverageStars($new_product) !!}
	        		<span class="text-grey">({{ $new_product->product_reviews->where('is_approved', true)->count() }} reviews)</span>
	        		@else
	        		<span class="text-grey">No reviews</span>
	        		@endif
	        	</div>
		      	<div class="description">
		      		{{ str_limit( $new_product->description, 90 ) }}
		      	</div>
		      	<div class="margin-top half">
		      		<strong >
		      		{{ Helpers::currencyFormat($new_product->price) }} 
		      		@if( $new_product->old_price ) 
		      		{!! Helpers::getDiscountHTML($new_product->price, $new_product->old_price) !!} 
		      		@endif
		      		</strong>
		      	</div>
	      	</div>
	      	@if( $new_product->in_stock )
		    <div class="ui bottom attached blue button add_to_cart"
		    @if( $new_product->discounted_price )
		    data-price="{{ $new_product->discounted_price }} "
		    @else
		    data-price="{{ $new_product->price }}"
      		@endif  
		    data-id="{{ $new_product->id }}" 
		    data-message="Added to cart">
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
	<div class="text-right">
		<a class="ui button primary" href="/product">View All</a>
	</div>
	@endif
</div>
@stop

@section('scripts')
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script>

$(document).ready(function(){
	$('.owl-carousel').owlCarousel({
	    stagePadding: 11,
	    margin:21,
	  	nav: true,
	  	navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:2
	        },
	        1000:{
	            items:4
	        }
	    }
	});

	$('.carousel').carousel({
        interval: 5000
    }).on('slide.bs.carousel', function (e)
    {
    	var parent = $(this).find('.active.item').parent();
    	parent.height(parent.height());
    }).on('slid.bs.carousel', function (e)
    {
    	var parent = $(this).find('.active.item').parent();
    	parent.height(parent.height());
        var nextH = $(e.relatedTarget).height();
        parent.animate({ height: nextH }, 500);
    });
});
</script>
@stop