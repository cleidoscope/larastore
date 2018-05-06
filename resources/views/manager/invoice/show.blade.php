@extends('manager.layout')

@section('body-class')
"body-dimmed"
@stop

@section('title')
<title>Invoice #{{ $invoice->id }} &rsaquo; My Account &rsaquo; {{ config('app.name') }}</title>
@stop


@section('content')
<div class="ui container">
	<div class="ui stackable grid">
		<div class="eleven wide column no-padding-bottom">	
			<div class="pull-right">
				<form method="POST" action="{{ route('manager.invoice.download', $invoice->id) }}">
					{{ csrf_field() }}
					<button class="ui button basic circular icon mini" type="submit" data-toggle="popup" data-content="Download" data-variation="inverted mini" data-position="bottom center"><i class="download icon"></i></button>
					<button class="ui button basic circular icon mini" type="button" id="printInvoice" data-toggle="popup" data-content="Print" data-variation="inverted mini" data-position="bottom center"><i class="print icon"></i></button>
				</form>
			</div>
			<a class="ui labeled icon default small circular button" href="{{ route('manager.invoice.index') }}"><i class="left chevron icon"></i>All Invoices</a>
		</div>

		<div class="sixteen wide mobile eleven wide tablet eleven wide computer column" id="printWrapper">	
			<div class="ui segment">
	        	<div class="ui @if( $invoice->isPaid ) green @else red @endif ribbon label huge" id="statusLabel">{{ $invoice->status }}</div>
				<div class="pull-right">
					<div class="ui segment center aligned">
						Amount due<br />
						<strong class="font-big">{{ Helpers::currencyFormat($invoice->amount - $invoice->transactions->sum('amount')) }}</strong>
					</div>
					@if( $invoice->isPaid )
					<span class="ui green label fluid text-center"><i class="icon check"></i>{{ $invoice->status }}</span>
		            @else
		            <?php  
		            $item_name = $invoice->items->store->name . '-' . $invoice->items->plan->plan;
		            $amount = $invoice->amount - $invoice->transactions->sum('amount');
		            ?>
					<form name="_xclick" id="paypal_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">
		                <input type="hidden" name="cmd" value="_xclick">
		                <input type="hidden" name="business" value="cleidoscope@gmail.com">
		                <input type="hidden" name="currency_code" value="PHP">
		                <input type="hidden" name="item_name" value="{{ $item_name }}">
		                <input type="hidden" name="item_number" value="{{ $invoice->id }}">
		                <input type="hidden" name="amount" value="{{ $amount }}">
		                <input type="hidden" name="return" id="return" value="{{ Request::url() }}">
		                <input type="image" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" align="left" alt="PayPal - The safer, easier way to pay online">
		            </form>
		            @endif
				</div>
		
				<img src="{{ asset('logo.png') }}" height="40" class="hidden" id="printLogo">
				<div class="ui header no-margin-bottom margin-top"><strong>Invoice #{{ $invoice->id }}</strong></div>
				<div>Invoice date: {{ $invoice->created_at }}</div>
				<div>Due date: {{ $invoice->due_at }}</div> <br />

				<strong>Bill To</strong>
				<div>{{ $invoice->bill_to->first_name }} {{ $invoice->bill_to->last_name }}</div>
				<div>{{ $invoice->bill_to->street }}, {{ $invoice->bill_to->city }}</div>
				<div>{{ $invoice->bill_to->province }} {{ $invoice->bill_to->zip }}</div>
				<div>{{ $invoice->bill_to->phone }}</div>
				<br />

				<strong>Pay To</strong>
				<div>Cloudstore Ecommerce Solutions</div>
				<div>Lipa City, Batangas 4217</div>

				<table class="ui table unstackable">
					<thead>
						<tr>
							<th>Description</th>
							<th class="right aligned">Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								{{$invoice->items->store->name}} - {{$invoice->items->plan->plan}}
							</td>
							<td class="right aligned">{{Helpers::currencyFormat($invoice->amount)}}</td>
						</tr>
						<tr class="right aligned">
							<td>Subtotal</td>
							<td>{{Helpers::currencyFormat($invoice->amount)}}</td>
						</tr>
						<tr class="right aligned">
							<td><strong>Total</strong></td>
							<td><strong>{{Helpers::currencyFormat($invoice->amount)}}</strong></td>
						</tr>
					</tbody>
				</table>

				<br />

				<label>Transactions</label>
				<table class="ui table fixed unstackable">
					<thead>
						<tr>
							<th>Date</th>
							<th>Gateway</th>
							<th>Transaction ID</th>
							<th class="right aligned">Amount</th>
						</tr>
					</thead>
					<tbody>
						@if(count($invoice->transactions) > 0)
						@foreach($invoice->transactions as $transaction)
						<tr>
							<td>{{$transaction->created_at}}</td>
							<td>{{$transaction->mode}}</td>
							<td>{{$transaction->mode_transaction}}</td>
							<td class="right aligned">{{Helpers::currencyFormat($transaction->amount)}}</td>
						</tr>
						@endforeach
						<tr class="right aligned">
							<td colspan="3">Total</td>
							<td><strong>{{Helpers::currencyFormat($invoice->transactions->sum('amount'))}}</strong></td>
						</tr>
						@else
						<tr class="text-center">
							<td colspan=4 class="text-muted">No transactions</td>
						</tr>
						@endif
						<tr class="right aligned">
							<td></td>
							<td></td>
							<td><strong>Balance</strong></td>
							<td><strong>{{Helpers::currencyFormat($invoice->amount - $invoice->transactions->sum('amount'))}}</strong></td>
						</tr>
					</tbody>
				</table>
				@if( $invoice->notes )
				<p class="font-small"><strong>Notes:</strong><br /> {{ $invoice->notes }}</p>
				@endif
			</div>
			<div class="margin-top font-small" id="paypalNote">
				<em>For payments made thru PayPal, it might take a few seconds before the payment will be reflected. Please refresh this page if you just made a payment with Paypal.</em>
			</div>
		</div>

		<div class="sixteen wide mobile five wide tablet five wide computer column">
			<div class="ui styled fluid accordion font-small">
			 	<div class="title">
				    <div class="font-black">
			    		<i class="dropdown icon"></i>
			    		LBC
			    	</div>
			  	</div>
				<div class="content">
					<strong>Consignee details:</strong> <br />
			    	Clyde Gail C. Escobidal <br />
			    	Lipa City, Batangas 4217 <br />
			    	09162792651
			    	<br /><br />
			    	<em>After you have made your payment, please send a picture or scanned copy of the LBC official receipt to <a href="mailto:billing@cloudstore.ph">billing@cloudstore.ph</a> using your registered email.</em>
				</div>

				<div class="title">
				    <div class="font-black">
					    <i class="dropdown icon"></i>
					    G-CASH
					</div>
				</div>
				<div class="content">
				    CLOUDSTORE.PH G-CASH Mobile Number: <br />
				    <strong>09162792651</strong>
				    <br /><br />
				    <em>In the "optional message", enter the invoice number of the invoice you wish to pay. Payments made through G-CASH will be credited within 3 to 6 hours.</em>
				</div>

				<div class="title">
				    <div class="font-black">
					    <i class="dropdown icon"></i>
					    MLhuillier
				    </div>
				</div>
				<div class="content">
					<strong>Receiver details:</strong> <br />
			    	Clyde Gail C. Escobidal <br />
			    	09162792651
			    	<br /><br />
			    	<em>After you have made your payment, please send a picture or scanned copy of the MLhuillier sendout form to <a href="mailto:billing@cloudstore.ph">billing@cloudstore.ph</a> using your registered email.</em>
				</div>


			</div>
		</div>
	</div>
</div>
@stop

@section('scripts')
<script>
jQuery(document).ready(function(){
	jQuery('#printInvoice').click(function(){
		var contents = $("#printWrapper").html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><body>');
        //Append the external CSS file.
        frameDoc.document.write('<link href="{{ asset('semantic/dist/semantic.min.css') }}" rel="stylesheet" type="text/css" />');
        frameDoc.document.write('<style type="text/css">html,body{height:auto}#statusLabel,#paypalNote,form{display:none}.pull-right{float:right}.no-margin-bottom{margin-bottom:0 !important}#printLogo{display:block}</style>');
        //Append the DIV contents.
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
    });
});
</script>
@stop
