@extends('admin.layout')

@section('title')
<title>{{ $user->full_name }} &rsaquo; Admin</title>
@stop



@section('content')
<div class="ui container margin-top">
	<br />
	<a class="ui button margin-bottom" href="{{ route('admin.user.index') }}"><i class="fa fa-angle-left"></i>&nbsp;&nbsp;All users</a>
	<div class="ui stackable two column grid">
		<div class="column">
			<p>
				ID: <strong>{{ $user->id }}</strong> <br />
				Full name: <strong>{{ $user->full_name }}</strong> <br />
				Email: <strong>{{ $user->email }}</strong> <br />
				Role: <strong>{{ $user->role }}</strong> <br />
				Registration type: <strong>{{ $user->registration_type }}</strong><br />
				Last login: 
				@if( $user->last_login )
	        	<?php $created_at = Carbon\Carbon::parse($user->last_login); ?>
	          	<strong>{{ $created_at->diffForHumans() }}</strong>
				@endif
			</p>
		</div>
		<div class="column">
			<p>
				Street: <strong>{{ $user->street }}</strong> <br />
				City: <strong>{{ $user->city }}</strong> <br />
				Province: <strong>{{ $user->province }}</strong> <br />
				ZIP: <strong>{{ $user->zip }}</strong> <br />
				Phone: <strong>{{ $user->phone }}</strong>
			</p>
		</div>
	</div>

	<div class="ui stackable grid">
		<div class="sixteen wide mobile twelve wide tablet twelve wide computer column">
			<div class="ui segment">
				<div class="ui header">Stores</div>
				<div class="table-responsive borderless">
					<table class="ui unstackable very basic table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Category</th>
								<th>Products</th>
								<th>Orders</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							@foreach( $user->stores as $store )
							<tr>
								<td>{{ $store->id }}</td>
								<td><a href="{{ route('admin.store.show', $store->id) }}">{{ $store->name }}</a></td>
								<td>{{ $store->store_category->category }}</td>
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

		<div class="sixteen wide mobile four wide tablet four wide computer column">
			<div class="ui segment">
				<div class="ui header">Activities</div>
				<div class="ui feed">
					@foreach( $user->activities as $activity )
				  	<div class="event">
					    <div class="content">
					      <div class="summary">
					      	{{ $activity->activity }}
					        <div class="date">
					        	<?php $created_at = Carbon\Carbon::parse($activity->created_at); ?>
					          	{{ $created_at->diffForHumans() }}
					        </div>
					      </div>
					    </div>
				  	</div>
				  	@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('scripts')
@stop