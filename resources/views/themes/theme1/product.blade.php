<?php 
$reviewed = !Auth::guest() ? Helpers::hasReviewed(Auth::user(), $product) : false; 
?>
@extends($storeTheme.'.layout')

@section('title')
<title>{{ $product->title }} &rsaquo; {{ $store->name }}</title>
@stop

@section('meta_tags')
<meta property="fb:app_id" 				content="1208410692601134" /> 
<meta property="og:type"   				content="product" /> 
<meta property="og:url"    				content="{{ Request::url() }}" /> 
<meta property="og:title"  				content="{{ $product->title }}" /> 
<meta property="og:description"  		content="{{ $product->description }}" /> 
<meta property="product:price:amount"   content="@if( $product->discounted_price ) {{ $product->discounted_price }} @else {{ $product->price }} @endif" /> 
<meta property="product:price:currency" content="PHP" /> 
<meta property="og:image"  @if( count($product->product_images ) > 0 ) content="{{ url('') . Helpers::getImage($product->product_images[0]->image) }}" @endif /> 
@stop

@section('content')
<div class="ui container margin-top">
	<div class="ui grid stackable margin-bottom">
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
			<h1 class="no-margin-bottom">{{ $product->title }}</h1>
			@if( $product->product_reviews->where('is_approved', true)->count() > 0 )
    		<div class="margin-bottom half">
	        	{!! Helpers::getRatingsAverageStars($product) !!}
    		</div>
	    	@endif
			<div class="font-weight-medium font-medium margin-top">
	      		{{ Helpers::currencyFormat($product->price) }}
			</div>

      		@if( $product->old_price ) 
      		<div>
      			<del>{{ Helpers::currencyFormat($product->old_price) }}</del>
      			<span class="font-weight-medium">{!! Helpers::getDiscountHTML($product->price, $product->old_price) !!}</span>
      		</div>
      		@endif
      		<p class="margin-top">{!! nl2br($product->description) !!}</p>

	      	@if( $product->in_stock )
      		<button type="button" class="ui button primary add_to_cart" id="product_add_to_cart"  data-id="{{ $product->id }}" data-message="Added to cart"><i class="cart icon"></i>Add to cart</button>
      		@else
      		<button type="button" class="ui button primary disabled">Out of stock</button>
      		@endif
			
			<div class="social-media-share margin-top">
                <div class="fb-share-button" 
			    	data-href="{{ url('') }}" 
			    	data-layout="button_count">
			  	</div>
                <div><a class="twitter-share-button" href="https://twitter.com/intent/tweet"></a></div>
			</div>
		</div>
	</div>

	<div class="ui grid stackable margin-bottom">
		<div class="ten wide tablet ten wide computer column">
			<div class="ui segment">
				<h3 class="font-medium">
					@if( Auth::guest() )
					<button class="ui button tiny primary right floated login_btn">Write a review</button>
					@else
						@if( $reviewed )
						<button class="ui button tiny primary right floated disabled">Reviewed</button>
						@else
						<button class="ui button tiny primary right floated" id="feedbackFormBtn">Write a review</button>
						@endif
					@endif
					Reviews
				</h3>
				<div class="ui comments no-margin-top">
					@if( count($product->product_reviews()->where('is_approved', true)->get() ) > 0 )
					@foreach( $product->product_reviews()->where('is_approved', true)->get() as $product_review )
				  	<div class="comment">
					    <div class="content">
					      	<a class="author">{{ $product_review->user->initial_name }}</a>
					      	<div class="metadata">
					        	<div class="date">{{ Helpers::human_date_diff($product_review->created_at) }}</div>
						        <div class="rating text-yellow">
	        						{!! Helpers::getRatingsStars($product_review->rating) !!}
	        					</div>
					      	</div>
					      	<div class="text">{{ $product_review->comment }}</div>
					    </div>
				  	</div>
				  	@endforeach
				  	@else
				  	<div class="text-center text-grey">No reviews yet</div>
				  	@endif
				</div>
			</div>
		</div>
	</div>
	

	@if( $product->product_category )
	<?php $related_products = $product->product_category->products->where('id', '<>', $product->id)->take(4); ?>
	@else
	<?php $related_products = $product->store->products->where('product_category_id', null)->where('id', '<>', $product->id)->take(4); ?>
	@endif
	
	@if( count($related_products) > 0 )
	<br />
	<h3 class="font-big">Related products</h3>
	<div class="ui four stackable cards">
		@foreach( $related_products as $related_product )
    	<div class="ui fluid card product-card">
      		<div class="image">
	      		<a href="{{ $related_product->url }}" class="product-image" @if( $related_product->product_images->count() > 0 ) style="background-image:url({{ Helpers::getImage($related_product->product_images[0]->image) }})" @endif title="{{ $related_product->title }}"">
	      		</a>
	      	</div>
	      	<div class="content">
	        	<a class="header" href="{{ $related_product->url }}">{{ $related_product->title }}</a>
	        	<div class="margin-bottom half">
	        		@if( $related_product->product_reviews->count() > 0 )
	        		{!! Helpers::getRatingsAverageStars($related_product) !!}
	        		<span class="text-grey">({{ $related_product->product_reviews->count() }} reviews)</span>
	        		@else
	        		<span class="text-grey">No reviews</span>
	        		@endif
	        	</div>
		      	<div class="description">
		      		{{ str_limit( $related_product->description, 90 ) }}
		      	</div>
		      	<div class="margin-top half">
		      		<strong>
		      		@if( $related_product->discounted_price ) 
		      		{{ Helpers::currencyFormat($related_product->discounted_price) }} 
		      		{!! Helpers::getDiscountHTML($related_product->price, $related_product->discounted_price) !!} 
					@else
		      		{{ Helpers::currencyFormat($related_product->price) }} 
		      		@endif
		      		</strong>
		      	</div>
	      	</div>
	      	@if( $related_product->in_stock )
		    <div class="ui bottom attached blue button add_to_cart" data-id="{{ $related_product->id }}" data-message="Added to cart">
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
	@endif
</div>

@if( !Auth::guest() && !$reviewed )
@include($storeTheme.'.partials.review-form')
@endif

@stop

@section('scripts')
<script>
@if( !Auth::guest() && !$reviewed )
$('#feedbackFormModal form')
.form({
fields: {
	rating : ['empty', 'number'],
}
});
$('#feedbackFormModal')
.modal('attach events', '#feedbackFormBtn', 'show')
.modal('attach events', '#closeFeedbackForm', 'hide')
.modal('setting', {
  autofocus: false,
});
$('#feedback_rating').rating({
	maxRating: 5,
	onRate: function(rating){
		$('#feedbackFormModal input[name=rating]').val(rating);
	}
});
@endif

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

<!-- Facebook Share -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>

<!-- Twitter Tweet -->
<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);
 
  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };
 
  return t;
}(document, "script", "twitter-wjs"));
</script>
@stop