@extends('manager.store.store-manager.layout')

@section('title')
<title>Subscribers &rsaquo; {{$store->name}} &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<button class="ui primary small circular button right floated" id="addSubscriber">Add subscriber</button>
<h2 class="no-margin-top no-margin-bottom">Subscribers</h2>
<div class="extra margin-bottom">Manage your store subscribers that will receive your newsletters.</div>
<div class="table-responsive margin-top">
	<table class="ui unstackable table">
		@if(count($store->newsletters) > 0) 
		<thead>
			<tr>
				<th>Full Name</th>
				<th>Email</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($store->store_subscribers()->paginate(25) as $subscriber)
			<tr class="top aligned">
				<td>{{ $subscriber->full_name }}</td>
				<td>{{ $subscriber->email }}</td>
				<td>{{ $subscriber->status }}</td>
				<td class="right aligned">
					<span class="font-small font-light">
						<a href="javascript:void(0)" class="editSubscriber underline" data-fullname="{{ $subscriber->full_name }}" data-email="{{ $subscriber->email }}" data-action="{{ route('manager.store-subscriber.update', ['store_id' => $store->id, 'id' => $subscriber->id]) }}">Edit</a>
						<span class="v-divider"></span>
						<a href="javascript:void(0)" class="deleteSubscriber underline" data-fullname="{{ $subscriber->full_name }}" data-action="{{ route('manager.store-subscriber.destroy', ['store_id' => $store->id, 'id' => $subscriber->id]) }}">Delete</a>
					</span>
				</td>
			</tr>
			@endforeach
		</tbody>
		@else
		<tbody>
			<tr class="text-center text-muted">
				<td colspan="3" class="extra">No subscribers</td>
			</tr>
		</tbody>
		@endif
	</table>
</div>

<div class="text-right margin-top"> 
{!! $store->store_subscribers()->paginate(25)->links('pagination.default') !!}
</div>

@include('manager.store.store-manager.store-subscriber.partials.form')
@stop

