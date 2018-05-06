@extends('manager.layout')

@section('body-class')
"body-dimmed"
@stop

@section('title')
<title>My Orders &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<?php $total = 0 ?>
<h3 class="text-center font-regular font-massive">My Orders</h3>
<div class="ui container">
	<div class="ui stackable grid invoices-container">
		@if( count( Auth::user()->orders ) > 0 )
		<div class="sixteen wide mobile eleven wide tablet twelve wide computer column">
			@foreach($orders as $order)
			<div class="table-responsive margin-bottom">
				<table class="ui unstackable table">
					<thead>
						<tr class="top aligned">
							<th>
								<div class="font-regular">Order</div> 
								<a href="{{ route('manager.order.show', $order->id) }}">#{{ $order->id }}</a>
							</th>
							<th>
								<div class="font-regular">Placed on</div> 
								{{ $order->created_at }}
							</th>
							<th>
								<div class="font-regular">Total</div> 
								{{ Helpers::currencyFormat($order->total) }}
							</th>
							<th>
								<div class="font-regular">Status</div>
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
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach( $order->order_items as $item )
						<tr>
							<td colspan="4">
								<h4 class="ui image header">
						        	<a href="{{ route('manager.order.show', $order->id) }}" class="order-product-thumb" @if( $item->product->product_images[0] )style="background-image: url({{ Helpers::getImage($item->product->product_images[0]->image) }})" @endif title="{{ $item->product->title }}"></a>
						          	<div class="content">
						            	<a href="{{ route('manager.order.show', $order->id) }}" class="font-black">{{ $item->product->title }}</a>
						            	<div class="sub header">
						            		Quantity: {{ $item['quantity'] }}
						            	</div>
						        	</div>
						      	</h4>
							</td>
						</tr>
						@endforeach
						<tr class="right aligned">
							<td colspan="4"><a class="ui circular primary small button" href="{{ route('manager.order.show', $order->id) }}">View order</a></td>
						</tr>
					</tbody>
				</table>
			</div>
			@endforeach
		</div>

		@else
		<div class="column text-center text-grey">You don't have any orders yet</div>
		@endif
	</div>
</div>
@stop