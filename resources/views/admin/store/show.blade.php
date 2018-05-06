@extends('admin.layout')

@section('title')
<title>{{ $store->name }} &rsaquo; Admin</title>
@stop



@section('content')
<div class="ui container margin-top">
	<br />
	<a class="ui button margin-bottom" href="{{ route('admin.store.index') }}"><i class="fa fa-angle-left"></i>&nbsp;&nbsp;All stores</a>

	<div class="text-center">
		<h2 class="no-margin-bottom">{{ $store->name }}</h2>
		<p>{{ $store->tagline }}</p>
	</div>
	
	<br />
	<div class="ui doubling stackable four cards">
	    <div class="card">
	    	<div class="content">
	    		<div class="ui header">Details</div>
				<p>
					Status: {!! Helpers::storeStatus($store) !!}
					@if( !$store->is_active && Helpers::storeInTrial($store) )
					({{ Helpers::trialIndays($store) }} days left)
					@endif
					<br />
					ID: {{ $store->id }}<br />
					User: <a href="{{ route('admin.user.show', $store->user->id) }}">{{ $store->user->full_name }}</a><br />
					Subdomain: {{ $store->subdomain }}<br />
					Category: {{ $store->store_category->category }}<br />
					Plan: {{ $store->plan->plan }} ({{ $store->plan->max_products }})<br />
					Current theme: {{ $store->store_theme->theme->title }}
				</p>
	    	</div>
	    </div>

	    <div class="card">
	    	<div class="content">
	    		<div class="ui header">Contact info</div>
				<p>
					Street: {{ $store->street }}<br />
					City: {{ $store->city }}<br />
					Province: {{ $store->province }}<br />
					ZIP code: {{ $store->zip_code }}<br />
					Phone: {{ $store->phone }}
				</p>
	    	</div>
	    </div>

	    <div class="card">
	    	<div class="content">
	    		<div class="ui header">Social media</div>
				<p>
					Facebook: {{ $store->facebook }}<br />
					Twitter: {{ $store->twitter }}<br />
					Instagram: {{ $store->instagram }}
				</p>
	    	</div>
	    </div>

	    <div class="card">
	    	<div class="content">
	    		<div class="ui header small">
	    			Products
	    			<span class="right floated font-light">{{ $store->products->count() }}</span>
	    		</div>
		    	<div class="ui header small">
		    		Orders
		    		<span class="right floated font-light">{{ $store->orders->count() }}</span>
		    	</div>
		    	<div class="ui header small">
		    		Product categories
		    		<span class="right floated font-light">{{ $store->product_categories->count() }}</span>
		    	</div>
		    	<div class="ui header small">
		    		Subscribers
		    		<span class="right floated font-light">{{ $store->store_subscribers->count() }}</span>
		    	</div>
	    	</div>
	    </div>
  	</div>
	
	<br />
  	<hr />
	<div class="ui segment">
		<div class="ui header">Products</div>
		<div class="table-responsive borderless">
			<table class="ui unstackable very basic table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Product</th>
						<th>Category</th>
						<th>Price</th>
						<th>Old price</th>
						<th>Weight</th>
					</tr>
				</thead>
				<tbody>
					@foreach( $store->products as $product )
					<tr>
						<td>{{ $product->id }}</td>
						<td>{{ $product->title }}</td>
						<td>{{ $product->product_category['category'] }}</td>
						<td>{{ Helpers::currencyFormat($product->price) }}</td>
						<td>{{ Helpers::currencyFormat($product->old_price) }}</td>
						<td>{{ number_format($product->weight, 2) }} kg</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<div class="ui stackable two column grid">
		<div class="column">
  			<div class="ui segment">
  				<div class="ui header">Orders</div>
  				<div class="table-responsive borderless">
  					<table class="ui unstackable very basic table">
  						<thead>
  							<tr>
  								<th>ID</th>
  								<th>Total</th>
  								<th>Status</th>
  							</tr>
  						</thead>
  						<tbody>
  							@foreach( $store->orders as $order )
  							<tr>
  								<td>{{ $order->id }}</td>
  								<td>{{ Helpers::currencyFormat($order->total) }}</td>
  								<td>{{ $order->status }}</td>
  							</tr>
  							@endforeach
  						</tbody>
  					</table>
  				</div>
  			</div>
		</div>
		
		<div class="column">
  			<div class="ui segment">
  				<div class="ui header">Product categories</div>
  				<div class="table-responsive borderless">
  					<table class="ui unstackable very basic table">
  						<thead>
  							<tr>
  								<th>ID</th>
  								<th>Category</th>
  							</tr>
  						</thead>
  						<tbody>
  							@foreach( $store->product_categories as $category )
  							<tr>
  								<td>{{ $category->id }}</td>
  								<td>{{ $category->category }}</td>
  							</tr>
  							@endforeach
  						</tbody>
  					</table>
  				</div>
  			</div>
		</div>

		<div class="column">
  			<div class="ui segment">
  				<div class="ui header">Subscribers</div>
  				<div class="table-responsive borderless">
  					<table class="ui unstackable very basic table">
  						<thead>
  							<tr>
  								<th>ID</th>
  								<th>Full name</th>
  								<th>Email</th>
  							</tr>
  						</thead>
  						<tbody>
  							@foreach( $store->store_subscribers as $subscriber )
  							<tr>
  								<td>{{ $subscriber->id }}</td>
  								<td>{{ $subscriber->full_name }}</td>
  								<td>{{ $subscriber->email }}</td>
  							</tr>
  							@endforeach
  						</tbody>
  					</table>
  				</div>
  			</div>
		</div>
	</div>
</div>
@stop

@section('scripts')
@stop