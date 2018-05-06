@extends('manager.layout')

@section('body-class')
"body-dimmed"
@stop

@section('title')
<title>Invoices &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<?php $total = 0 ?>
<h3 class="text-center font-regular font-massive">Invoices</h3>

<div class="ui container">
	<div class="ui stackable grid invoices-container">
		@if( count($invoices) > 0 )
		<div class="sixteen wide mobile eleven wide tablet twelve wide computer column">
			<div class="table-responsive">
				<table class="ui unstackable table">
					<thead>
						<tr>
							<th>Invoice #</th>
							<th>Status</th>
							<th>Amount Due</th>
							<th>Date Created</th>
						</tr>
					</thead>
					<tbody>
						@foreach($invoices as $invoice)
						<tr>
							<td><strong><a href="{{route('manager.invoice.show', $invoice->id)}}">{{$invoice->id}}</a></strong></td>
							<td>
							@if( $invoice->isPaid )
							<span class="ui green label"> 
							{{ $invoice->status }}
							</span>
							@else
							<span class="ui red horizontal label"> 
							{{ $invoice->status }}
							</span>
							@endif
							</td>
							<td>{{ Helpers::currencyFormat($invoice->amount_due) }}</td>
							<td>{{ $invoice->created_at }}</td>
						</tr>
						<?php $total += $invoice->amount_due ?>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

		<div class="sixteen wide mobile five wide tablet four wide computer column">
			<div class="ui segment center aligned">
				Total Amount Due
				<div class="ui header">{{Helpers::currencyFormat($total)}}</div>
			</div>
			<em class="font-small">Please pay your balance to avoid disruption of service.</em>
		</div>
		@else
		<div class="column text-center text-grey">You don't have any invoices yet</div>
		@endif
	</div>
</div>
@stop