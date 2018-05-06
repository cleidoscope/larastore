@extends('manager.store.store-manager.layout')

@section('title')
<title>Orders &rsaquo; {{$store->name}} &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<h2 class="no-margin-top no-margin-bottom">Orders</h2>
<div class="extra margin-bottom">Manage your store orders and order items. The total revenue of your store is calculated from the <strong>completed</strong> orders.</div>
<div class="table-responsive">
	<table class="ui unstackable table">
		@if(count($store->orders) > 0) 
		<thead>
			<tr>
				<th>Order</th>
				<th>Customer</th>
				<th>Total</th>
				<th>Placed On</th>
				<th class="right aligned">Status</th>
			</tr>
		</thead>
		<tbody>
			@foreach($store->orders()->paginate(25) as $order)
			<tr class="top aligned">
				<td><a href="{{ route('manager.store-order.show', ['store_id' => $store->id, 'id' => $order->id]) }}"><strong>#{{ $order->id }}</strong></a></td>
				<td>{{ $order->user->full_name }}</td>
				<td>{{ Helpers::currencyFormat($order->total) }}</td>
				<td>{{ $order->created_at }}</td>
				<td class="right aligned">
					@if( $order->status == 'pending' )
					<span class="ui yellow label">Pending</span>
					@elseif( $order->status == 'failed' )
					<span class="ui red label">Failed</span>
					@elseif( $order->status == 'processing' )
					<span class="ui teal label">Processing</span>
					@elseif( $order->status == 'completed' )
					<span class="ui green label">Completed</span>
					@elseif( $order->status == 'cancelled' )
					<span class="ui grey label">Cancelled</span>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
		@else
		<tbody>
			<tr class="text-center text-muted">
				<td class="extra">No orders.</td>
			</tr>
		</tbody>
		@endif
	</table>
</div>

<div class="text-right margin-top"> 
{!! $store->orders()->paginate(25)->links('pagination.default') !!}
</div>
@stop

