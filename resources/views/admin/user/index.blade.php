@extends('admin.layout')

@section('title')
<title>Users &rsaquo; Admin</title>
@stop



@section('content')
<div class="ui container margin-top">
	<h2>Users ({{ $users->count() }})</h2> 
	<div class="ui segment">
		<div class="ui stackable grid">
			<div class="column">
				<div class="table-responsive borderless">
					<table class="ui very basic unstackable table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Full name</th>
								<th>Email</th>
								<th>Stores</th>
								<th>Date registered</th>
								<th>Last login</th>
							</tr>
						</thead>
						<tbody>
							@foreach( $users as $user )
							<tr>
								<td>{{ $user->id }}</td>
								<td><a href="{{ route('admin.user.show', $user->id) }}">{{ $user->full_name }}</a></td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->stores->count() }}</td>
								<td>{{ date_format($user->created_at, 'M d, Y - h:i a') }}</td>
								<td>
									@if( $user->last_login )
						        	<?php $created_at = Carbon\Carbon::parse($user->last_login); ?>
						          	{{ $created_at->diffForHumans() }}
									@endif
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="text-right margin-top"> 
	{!! $users->links('pagination.default') !!}
	</div>
</div>
@stop
