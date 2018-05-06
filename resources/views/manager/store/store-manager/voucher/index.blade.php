@extends('manager.store.store-manager.layout')

@section('title')
<title>Vouchers &rsaquo; {{$store->name}} &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<button class="ui primary circular small button right floated" id="addVoucher">Add voucher</button>
<h2 class="no-margin-top no-margin-bottom">Vouchers</h2>
<div class="extra margin-bottom">Add voucher codes for your product promos and discounts. Your customers can use the voucher code only once.</div>
<div class="table-responsive margin-top">
	<table class="ui unstackable table">
		@if(count($store->vouchers) > 0) 
		<thead>
			<tr>
				<th>Voucher Code</th>
				<th>Discount</th>
				<th>Valid Until</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($store->vouchers()->paginate(25) as $voucher)
			<tr class="top aligned">
				<td>{{ $voucher->code }}</td>
				<td>{{ Helpers::currencyFormat($voucher->discount) }}</td>
				<td>{{ $voucher->valid_until }}</td>
				<td class="right aligned">
					<span class="font-small font-light">
						<a href="javascript:void(0)" class="editVoucher underline" data-code="{{ $voucher->code }}" data-discount="{{ $voucher->discount }}" data-valid-until="{{ date_format(date_create($voucher->valid_until), 'Y-m-d') }}" data-action="{{ route('manager.voucher.update', ['store_id' => $store->id, 'id' => $voucher->id]) }}">Edit</a>
						<span class="v-divider"></span>
						<a href="javascript:void(0)" class="deleteVoucher underline" data-code="{{ $voucher->code }}" data-action="{{ route('manager.voucher.destroy', ['store_id' => $store->id, 'id' => $voucher->id]) }}">Delete</a>
					</span>
				</td>
			</tr>
			@endforeach
		</tbody>
		@else
		<tbody>
			<tr class="text-center text-muted">
				<td colspan="3" class="extra">No vouchers</td>
			</tr>
		</tbody>
		@endif
	</table>
</div>

<div class="text-right margin-top"> 
{!! $store->vouchers()->paginate(25)->links('pagination.default') !!}
</div>

@include('manager.store.store-manager.voucher.partials.form')
@stop

