<nav class="ui top fixed menu">
  	<div class="item"><a class="brand-logo font-size-big font-bold font-monserrat" href="{{ url('') }}">{{ $store->name }}</a></div>
  	<div class="item"><a class="text-white theme-link @if( Request::is('product') ) active @endif" href="/product">All Products</a></div>

	@foreach( $store->product_categories as $product_category  )
	<div class="item">
		<div class="item">
			<a class="text-white theme-link @if( Request::is($product_category->slug) ) active @endif" href="/{{ $product_category->slug }}">
				{{ $product_category->category }} 
			</a>
		</div>
	</div>
	@endforeach

  	@if( count($store->products->where('product_category_id', NULL)) > 0 )
	<div class="item">
		<a class="text-white theme-link @if( Request::is('uncategorized') ) active @endif" href="/uncategorized">
			Uncategorized
		</a>
	</div>
  	@endif

  	<div class="right item">
  		<div class="item"><a class="text-white theme-link" href="dds">Log In</a></div>
  	</div>
</nav>