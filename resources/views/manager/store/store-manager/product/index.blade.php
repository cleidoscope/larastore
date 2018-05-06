@extends('manager.store.store-manager.layout')

@section('title')
<title>Products &rsaquo; {{$store->name}} &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<div class="material-card no-margin-bottom">
	<div class="material-card-header">
        @if( $store->is_pro || $store->products->count() < $store->plan->max_products )
		<a class="ui white right circular small button right floated" href="{{ route('manager.product.create', $store->id) }}">Add product</a>
		@else
		<a class="ui button white right floated disabled">Add product</a>
		@endif

        <h4 class="title">Products</h4>
        @if( $store->is_pro )
	    <div class="subtitle">{{ $store->products->count() }}</div>
	    @else
	    <div class="subtitle">{{ $store->products->count() }}/{{ $store->plan->max_products }}</div>
	    @endif
    </div>

	<div class="material-card-content">
		<form method="GET">
		    <div class="ui action input search small">
		        <input type="search" name="search" placeholder="Search products.." value="{{ Request::input('search') }}">
		        <button class="ui button" type="submit"><i class="fa fa-search"></i></button>
		    </div>
		</form>
		<div class="table-responsive margin-top">
			<table class="ui unstackable table">
				@if(count($products) > 0) 
				<thead>
					<tr>
						<th>Name</th>
						<th>Price</th>
						<th>Category</th>
						<th>Availability</th>
					</tr>
				</thead>
				<tbody>
					@foreach( $products as $product )
					<tr class="top aligned">
						<td><a href="{{ route('manager.product.edit', ['store_id' => $store->id, 'product_id' => $product->id]) }}">{{ $product->title }}</a></td>
						<td>{{ Helpers::currencyFormat($product->price) }}</td>
						<td>
						@if( $product->product_category ) {{ $product->product_category->category }}
						@else Uncategorized
						@endif
						</td>
						<td>@if( $product->in_stock ) In stock @else Out of stock @endif</td>
					</tr>
					@endforeach
				</tbody>
				@else
				<tbody>
					<tr class="text-center text-muted">
						<td class="extra">No products</td>
					</tr>
				</tbody>
				@endif
			</table>
		</div>
	</div>
</div>

<div class="text-right margin-top"> 
{!! $products->links('pagination.default') !!}
</div>
@stop

@section('scripts')
<script src="{{ asset('js/tablesort.js') }}"></script>
<script>
jQuery(document).ready(function(){
    $('.ui.table.sortable').tablesort();
});
</script>
@stop
