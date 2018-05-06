@extends('manager.store.store-manager.layout')

@section('title')
<title>Newsletters &rsaquo; {{$store->name}} &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<button class="ui primary small circular button right floated" id="addNewsletter">Add newsletter</button>
<h2 class="no-margin-top no-margin-bottom">Newsletters</h2>
<div class="extra margin-bottom">Send out email promos and updates to your store subscribers. You can choose to send to all your store subscribers, or to a specific email.</div>
<div class="table-responsive margin-top">
	<table class="ui unstackable table">
		@if(count($store->newsletters()->paginate(25)) > 0) 
		<thead>
			<tr>
				<th>Subject</th>
				<th>Created At</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($store->newsletters as $newsletter)
			<tr class="top aligned">
				<td>{{ $newsletter->subject }}</td>
				<td>{{ $newsletter->created_at }}</td>
				<td class="right aligned">
					<span class="font-small font-light">
						<a href="javascript:void(0)" class="sendNewsletter underline" data-subject="{{ $newsletter->subject }}" data-action="{{ route('manager.newsletter.send', ['store_id' => $store->id, 'id' => $newsletter->id]) }}">Send</a>
						<span class="v-divider"></span>
						<a href="javascript:void(0)" class="editNewsletter underline" data-subject="{{ $newsletter->subject }}" data-message="{{ $newsletter->message }}" data-action="{{ route('manager.newsletter.update', ['store_id' => $store->id, 'id' => $newsletter->id]) }}">Edit</a>
						<span class="v-divider"></span>
						<a href="javascript:void(0)" class="deleteNewsletter underline" data-subject="{{ $newsletter->subject }}" data-action="{{ route('manager.newsletter.destroy', ['store_id' => $store->id, 'id' => $newsletter->id]) }}">Delete</a>
					</span>
				</td>
			</tr>
			@endforeach
		</tbody>
		@else
		<tbody>
			<tr class="text-center text-muted">
				<td colspan="3" class="extra">No newsletters</td>
			</tr>
		</tbody>
		@endif
	</table>
</div>

<div class="text-right margin-top"> 
{!! $store->newsletters()->paginate(25)->links('pagination.default') !!}
</div>

@include('manager.store.store-manager.newsletter.partials.form')
@stop

