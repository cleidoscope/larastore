@extends('admin.layout')

@section('title')
<title>Stores &rsaquo; Admin</title>
@stop



@section('content')
<div class="ui container margin-top">
	<h2>Stores ({{ $allStores->count() }})</h2> 
	<div class="ui segment">
		<div class="ui stackable grid">

			<!-- Stores chart -->
			<div class="sixteen wide mobile four wide tablet four wide computer column">
				<canvas id="ordersChart"></canvas>
			</div>


			<div class="sixteen wide mobile twelve wide tablet twelve wide computer column">
				<div class="table-responsive borderless">
					<table class="ui very basic unstackable table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Products</th>
								<th>Orders</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							@foreach( $stores as $store )
							<tr>
								<td>{{ $store->id }}</td>
								<td><a href="{{ route('admin.store.show', $store->id) }}">{{ $store->name }}</a></td>
								<td>{{ $store->products->count() }}</td>
								<td>{{ $store->orders->count() }}</td>
								<td>{!! Helpers::storeStatus($store) !!}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="text-right margin-top"> 
	{!! $stores->links('pagination.default') !!}
	</div>
</div>
@stop

@section('scripts')
<script src="{{ asset('js/chart.min.js') }}"></script>
<script>
$(document).ready(function(){
	var storesChart = $("#ordersChart");

	// Store Report
	new Chart(storesChart, {
	    type: 'pie',
	    data: {
	        labels: ['Trial', 'Active', 'Inactive'],
	        datasets: [{
	            data: [
	            	'{{ $trialStores }}', 
	            	'{{ $activeStores }}', 
	            	'{{ $inactiveStores }}'
	            ],
	            backgroundColor: [
	                '#FBBD08',
	                '#21BA45',
	                '#DB2828',
	            ],
	            borderWidth: 0,
	        }]
	    },
	    options: {
		    responsive: true,
	    }
	});
});
</script>
@stop