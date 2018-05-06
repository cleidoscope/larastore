@extends('manager.layout')

@section('body-class')
"body-dimmed"
@stop

@section('title')
<title>Order #{{ $order->id }} &rsaquo; My Orders &rsaquo;  {{ config('app.name')}}</title>
@stop

@section('content')
<div class="ui container">
	<div class="ui grid">
		<div class="column">
			<a class="ui circular labeled icon default button" href="{{ route('manager.order.index') }}">
				<i class="left chevron icon"></i>
				All Orders
			</a>
			<div class="ui segment">
				<div class="margin-bottom"> 
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
				</div>

				<h2 class="no-margin-top no-margin-bottom">Order #{{ $order->id }}</h2>
				<div class="extra">Store: <a href="{{ $order->store->url }}">{{ $order->store->name }}</a></div>
				<div class="extra">Placed on {{ $order->created_at }}</div>
					<br />
					<div class="ui three column grid">
					<div class="row">
						<div class="column">
							<h4 class="no-margin-bottom">Shipping Address</h4>
							{{ $order->shipping_address->first_name }} {{ $order->shipping_address->last_name }}<br />
							{{ $order->shipping_address->street }}<br />
							{{ $order->shipping_address->city }}, {{ $order->shipping_address->province }}, {{ $order->shipping_address->zip }}<br />
							{{ $order->shipping_address->phone }}
						</div>

						<div class="column">
							<h4 class="no-margin-bottom">Shipping Method</h4>
							{{ $order->shipping_method->title }}<br />
							Shipping fee: {{ Helpers::currencyFormat($order->shipping_fee) }}
						</div>

						<div class="column">
							<h4 class="no-margin-bottom">Payment Mode</h4>
							{{ $order->payment_mode->title }}
						</div>
					</div>
				</div>
			</div>

			<div class="ui segment">
				<table class="ui very basic table">
					<thead>
						<tr>
							<th>Product</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php $total = 0; ?>
						@foreach( $order->order_items as $item )
						<?php
						if( $item->discounted_price ) :
			      		$price = $item->discounted_price * $item->quantity;
			      		else :
			      		$price = $item->price * $item->quantity;
			      		endif;
						?>
						<tr class="top aligned">
							<td>
								<h4 class="ui image header">
						        	<a href="{{ $order->store->url }}{{ $item->product->url }}" class="order-product-thumb" @if( $item->product->product_images[0] )style="background-image: url({{ Helpers::getImage($item->product->product_images[0]->image) }})" @endif title="{{ $item->product->title }}"></a>
						          	<div class="content">
						            	<a href="{{ $order->store->url }}{{ $item->product->url }}">{{ $item->product->title }}</a>
						        	</div>
						      	</h4>
						    </td>
							<td>
								@if( $item->discounted_price ) 
					      		<strong>{{ Helpers::currencyFormat($item->discounted_price) }}</strong> <br />
					      		<del class="font-regular">{{ Helpers::currencyFormat($item->price) }}</del>
					      		{!! Helpers::getDiscountHTML($item->price, $item->discounted_price) !!} 
								@else
					      		<strong>{{ Helpers::currencyFormat($item->price) }}</strong>
					      		@endif
							</td>
							<td>{{ $item->quantity }}</td>
							<td>{{ Helpers::currencyFormat($price) }}</td>
						</tr>
						<?php $total += $price; ?>
						@endforeach
					</tbody>
				</table>

				<div class="ui grid">
					<div class="sixteen wide mobile six wide tablet six wide computer column">
						@if( $order->notes )
						<p class="font-small"><strong>Notes:</strong><br /> {{ $order->notes }}</p>
						@endif
					</div>
					<div class="sixteen wide mobile six wide tablet six wide computer column"></div>
					<div class="sixteen wide mobile four wide tablet four wide computer column">
						<table class="ui very basic table">
							<tbody>
								<tr class="top aligned">
									<td>
										Subtotal<br />
										Shipping fee
										@if( $order->voucher )
										<br />Voucher ({{ $order->voucher->code }})
										@endif
									</td>
									<td class="right aligned">
										{{ Helpers::currencyFormat($total) }}<br />
										{{ Helpers::currencyFormat($order->shipping_fee) }}
										@if( $order->voucher )
										<br />- {{ Helpers::currencyFormat($order->voucher->discount) }}
										@endif
									</td>
								</tr>
								<tr>
									<td><h3>Total</h3></td>
									<td class="right aligned"><h3>{{ Helpers::currencyFormat($order->total) }}</h3></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop