@extends($storeTheme.'.layout')
<?php $carousels = $store->carousels; ?>

@section('title')
<title>{{ $store->name }}</title>
@stop





@section('content')
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

@if( $store->products->where('is_featured', true)->count() > 0 )
<div class="ui stackable grid margin-bottom">
	<div class="sixteen wide column">
		<br />
		<h3 class="text-center margin-top font-size-big margin-bottom font-monserrat">Featured Products</h3>
	</div>
	
	<div class="sixteen wide mobile two wide tablet two wide computer column"></div>
	<div class="sixteen wide mobile twelve wide tablet twelve wide computer column">
		<div class="owl-carousel owl-theme">
			@foreach( $store->products->where('is_featured', true) as $featured_product )
			<div class="featured-product text-center">
				<div class="featured-product-header">
					<span class="font-bold font-size-medium text-grey font-monserrat">{{ $featured_product->title }}</span>
					<p class="margin-top half">{{ str_limit( $featured_product->description, 95 ) }}</p>
				</div>

	      		<div class="featured-product-image" title="{{ $featured_product->title }}">
	      			@if( $featured_product->product_images->count() > 0 )
	      			<img src="{{ Helpers::getImage($featured_product->product_images[0]->image) }}">
	      			@endif
	      		</div>

				<div class="margin-top">
	      			<a class="font-bold theme-link margin-bottom half" href="{{ $featured_product->url }}">View product <i class="fa fa-long-arrow-right"></i></a>
	      		</div>
			</div>
			@endforeach
		</div>
	</div>
</div> 
@endif


<div class="latest-products margin-top">
	<h3 class="font-size-big margin-bottom font-monserrat no-margin-top">Latest Products</h3>

	<div class="ui four column stackable grid">
		@foreach( $store->products->take(8) as $new_product )
		<div class="column">
	    	<div class="product-card text-center">
	      		<a class="image margin-bottom" href="{{ $new_product->url }}" title="{{ $new_product->title }}">
	      			@if( $new_product->product_images->count() > 0 )
	      			<img src="{{ Helpers::getImage($new_product->product_images[0]->image) }}">
	      			@endif
	      		</a>
		      	<div class="content">
		        	<a class="text-black" href="{{ $new_product->url }}">{{ $new_product->title }}</a>
			      	<div class="margin-top half font-bold">
			      		@if( $new_product->discounted_price ) 
			      		{{ Helpers::currencyFormat($new_product->discounted_price) }} 
			      		{!! Helpers::getDiscountHTML($new_product->price, $new_product->discounted_price) !!} 
						@else
			      		{{ Helpers::currencyFormat($new_product->price) }} 
			      		@endif
			      	</div>
		      	</div>
	    	</div>
    	</div>
		@endforeach
	</div>
</div>
@stop

@section('scripts')
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script>

$(document).ready(function(){
	$('.owl-carousel').owlCarousel({
	    stagePadding: 10,
	    margin:20,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:2
	        },
	        1000:{
	            items:3
	        }
	    }
	});

	$('.carousel').carousel({
        interval: 4000
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