<div class="ui container nav-container">
	<nav>
		<div class="ui icon secondary menu computer-menu">
		  	<a class="item @if( Route::currentRouteName() == 'homepage' ) active @endif" href="{{ url('') }}">Home</a>
		  	<a class="item @if( Request::is('product') ) active @endif" href="/product">Products</a>

			<div class="ui dropdown item">
	          	Categories <i class="angle down icon"></i>
	          	<div class="menu">
				  	@foreach( $store->product_categories as $product_category  )
			  		<a class="item @if( Request::is($product_category->slug) ) active @endif" href="/{{ $product_category->slug }}">{{ $product_category->category }}</a>
				  	@endforeach
				  	@if( $store->products()->where('product_category_id', NULL)->count() > 0 )
			  		<a class="item @if( Request::is('uncategorized') ) active @endif" href="/uncategorized">Uncategorized</a>
			  		@endif
	          	</div>		        
	        </div>
			<div class="ui right secondary menu">
				<form class="ui item" method="GET" action="/product">
					<div class="ui icon small input">
					  <input type="search" name="search" value="{{ Request::input('search') }}" placeholder="Search products...">
					  <i class="search icon"></i>
					</div>
				</form>
		    	<a class="ui item @if( Route::currentRouteName() == 'cart' ) active @endif" href="/cart">
					<i class="shopping cart icon"></i> 
					<div class="ui blue circular label small cart_total_items">{{ Helpers::cartTotalItems($store) }}</div>
				</a>
				@if( Auth::guest() )
				<a class="ui item login_btn">
		          	<i class="user outline icon"></i>
				</a>
	          	@else
				<div class="ui dropdown item">
		          	<i class="user outline icon"></i>
		          	<div class="menu">
			            <a class="item" href="{{route('manager.store.index')}}">My Stores</a>
			            <a class="item" href="{{route('manager.order.index')}}">My Orders</a>
			            <a class="item" href="{{route('manager.invoice.index')}}">Invoices</a>
	  					<a class="item" href="{{ route('manager.user.show') }}">Account Settings</a>
			            <form method="POST" action="{{ route('auth.logout') }}">
			              {{csrf_field()}}
			              <button type="submit" class="ui fluid button flat font-regular">Logout</button>
			            </form>
		          	</div>		        
		        </div>
		        @endif
			</div>
		</div>
	</nav>


	<!-- <div class="tablet mobile only row">
      <div class="ui fluid secondary menu no-margin-bottom">
        <div class="header item no-padding-left no-padding-top no-padding-bottom">
			@if( !empty( $store->store_logo ) )
			<a href="{{ url('') }}" class="brand-logo no-padding-left"><img src="{{ Helpers::getImage($store->store_logo) }}" class="no-margin-top no-margin-left"></a>
			@endif	
        </div>
        <div class="right menu">
          <a class="menu item no-padding-right no-margin-right toggle-container">
            <div class="ui basic icon toggle button">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </a>
        </div>
      </div>
      <div class="ui vertical accordion fluid secondary menu no-margin-top">
      	<div class="item">
			<a class="ui small button blue" href="/cart">
				<i class="fa fa-shopping-cart"></i> 
				<span id="cart_total_items">{{ Helpers::cartTotalItems($store) }}</span> item(s) 
				-
				<span id="cart_total_amount">{{ Helpers::cartTotalAmount($store) }}</span>
			</a>
		</div>
		<div class="item">
			<div class="social-media"> 
				@if( !empty( $store->facebook ) ) <a href="https://www.facebook.com/{{ $store->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a> @endif
				@if( !empty( $store->twitter ) ) <a href="https://twitter.com/{{ $store->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a> @endif
				@if( !empty( $store->instagram ) ) <a href="https://www.instagram.com/{{ $store->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a> @endif
			</div>
		</div>
		@if( Auth::guest() )
      	<div class="item">
            <a class="ui button primary login_btn">Login</a>
      	</div>
      	@else
      	<div class="item">
            <div class="title">
              Hi {{Auth::user()->first_name}}&nbsp;
              <i class="fa fa-angle-down"></i>
            </div>
            <div class="content">
              <a class="item" href="{{ route('manager.store.index') }}">My Stores</a>
              <a class="item" href="{{ route('manager.order.index') }}">My Orders</a>
              <a class="item" href="{{ route('manager.invoice.index') }}">Invoices</a>
              <a class="item" href="{{ route('manager.user.show') }}">Account Settings</a>
              <form method="POST" action="{{ route('auth.logout') }}">
                {{csrf_field()}}
                <button type="submit" class="ui fluid button flat font-regular">Logout</button>
              </form>
            </div>
      	</div>
      	@endif
      </div>
	</div> -->


	<div class="brand-heading">
		<div class="text-center">
			@if( !empty( $store->store_logo ) )
			<a class="brand-logo padding-left" href="{{ url('') }}">
				<img src="{{ Helpers::storeLogo($store->store_logo, 50) }}" srcset="{{ Helpers::storeLogo($store->store_logo) }} 2x" alt="{{ $store->name }}" title="{{ $store->name }}">
			</a>
			@endif	
			<h1 class="no-margin all-capss font-montserrat font-massive site-title">{{ $store->name }}</h1>
			<h2 class="no-margin-top margin-bottom half">{{ $store->tagline }}</h2>

			<div class="social-media"> 
				@if( !empty( $store->facebook ) ) <a href="https://www.facebook.com/{{ $store->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a> @endif
				@if( !empty( $store->twitter ) ) <a href="https://twitter.com/{{ $store->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a> @endif
				@if( !empty( $store->instagram ) ) <a href="https://www.instagram.com/{{ $store->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a> @endif
			</div>
		</div>
	</div>
	
</div>



		

		<!-- <div class="ui inverted blue pointing stackable menu product-categories">
		  	<a class="item @if( Request::is('product') ) active @endif" href="/product">
		  		All Products 
		  		<span class="ui left pointing label">{{ $store->products->count() }}</span>
		  	</a>
		  	@foreach( $store->product_categories as $product_category  )
	  		<a class="item @if( Request::is($product_category->slug) ) active @endif" href="/{{ $product_category->slug }}">
	  			{{ $product_category->category }} 
	  			<span class="ui left pointing label">{{ $product_category->products->count() }}</span>
	  		</a>
		  	@endforeach
		  	@if( count($store->products->where('product_category_id', NULL)) > 0 )
	  		<a class="item @if( Request::is('uncategorized') ) active @endif" href="/uncategorized">
	  			Uncategorized
	  			<span class="ui left pointing label">{{ count($store->products->where('product_category_id', NULL))	 }}</span>
	  		</a>
		  	@endif
		</div>
		<div class="no-margin-top">
			@if( Route::currentRouteName() == 'store.product.show' )
			<div class="ui breadcrumb">
				@if( $product->product_category )
				<a class="section" href="/{{ $product->product_category->slug }}">{{ $product->product_category->category }}</a>
				@else
				<a class="section" href="/uncategorized">Uncategorized</a>
				@endif
				<i class="right angle icon divider"></i>
				<div class="active section">{{ $product->title }}</div>
			</div>
			@endif
			<form method="GET" action="/product" class="pull-right no-margin-top margin-bottom">
				<div class="ui action input small">
					<input type="search" placeholder="Search products..." name="search" value="{{ Request::input('search') }}">
	  				<button type="submit" class="ui icon button"><i class="search icon"></i></button>
				</div>
			</form>
		<div class="clearfix"></div>
		</div> -->


