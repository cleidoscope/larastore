@extends('manager.store.store-manager.layout')

@section('title')
<title>Product Reviews &rsaquo; {{ $store->name }} &rsaquo; {{ config('app.name') }}</title>
@stop

@section('content')
<h2 class="no-margin-top no-margin-bottom">Product Reviews</h2>
<div class="extra margin-bottom">Approve reviews for your products or delete the unnecessary ones.</div>
<div class="table-responsive">
	<table class="ui unstackable table">
		@if(count($reviews) > 0) 
		<thead>
			<tr>
				<th>Rating</th>
				<th>Comment</th>
				<th>Author</th>
				<th>Product</th>
				<th>Date Posted</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach( $reviews as $review )
			<tr class="top aligned">
				<td>{!! Helpers::getRatingsStars($review->rating) !!}</td>
				<td class="five wide">{{ $review->comment }}</td>
				<td>{{ $review->user->initial_name }}</td>
				<td><a href="{{ route('manager.product.edit', ['store_id' => $store->id, 'id' => $review->product->id]) }}">{{ $review->product->title }}</a></td>
				<td>{{ date_format(date_create($review->created_at), 'M d, Y') }}</td>
				<td class="right aligned">
					<span class="font-small font-light">
						@if( !$review->is_approved )
						<a href="javascript:void(0)" class="approveReview underline" data-action="{{ route('manager.review.update', ['store_id' => $store->id, 'id' => $review->id]) }}">Approve</a>
						<span class="v-divider"></span>
						@endif
						<a href="javascript:void(0)" class="deleteReview underline" data-action="{{ route('manager.review.destroy', ['store_id' => $store->id, 'id' => $review->id]) }}">Delete</a>
					</span>
				</td>
			</tr>
			@endforeach
		</tbody>
		@else
		<tbody>
			<tr class="text-center text-muted">
				<td colspan="3" class="extra">No product reviews</td>
			</tr>
		</tbody>
		@endif
	</table>
</div>
<div class="text-right margin-top"> 
{!! $reviews->links('pagination.default') !!}
</div>

@include('manager.store.store-manager.product-review.partials.form')
@stop

