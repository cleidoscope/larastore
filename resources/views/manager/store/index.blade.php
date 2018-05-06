@extends('manager.layout')

@section('body-class')
"body-dimmed"
@stop

@section('title')
<title>My Stores &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
@if( count( Auth::user()->stores ) > 0 )
<h3 class="text-center font-regular font-massive">My Stores</h3>
<br />
@endif

<div class="ui container">
	<div class="ui stackable grid margin-bottom">
		<div class="column">
			@if( count( Auth::user()->stores ) > 0 )
			<div class="ui four stackable doubling cards">
				@foreach( Auth::user()->stores as $store )
			  	<div class="card">
				    <div class="image">
				    	<img src="{{ $store->store_theme->theme->preview }}">
				    	{!! Helpers::storeStatus($store, true) !!}
				    </div>
				    <div class="content">
				    	@if( $store->is_active )
				      	<a class="right floated" href="{{ $store->url }}" target="_blank"><i class="fa fa-link"></i></a>
				      	@endif
				      	<div class="header">{{ $store->name }}</div>
				      	<div>{{ $store->store_category->category }}</div>
				      	<div>{{ $store->products->count() }} products</div>
				    </div>
				    <a class="ui bottom attached button primary large" href="{{ route('manager.store.show', $store->id) }}">Manage Store</a>
			  	</div>
			  	@endforeach

			  	<div class="card card-new">
			  		<div class="content">
				  		<a class="circular ui icon button big primary" href="{{route('manager.store.create')}}" data-toggle="popup" data-content="Create New Store" data-variation="small" data-position="top center">
						  <i class="icon plus"></i>
						</a>
					</div>
			  	</div>
			</div>
			@else
			<div class="no-stores-container text-center">
				<h3 class="font-thin font-extra-massive">Welcome to Cloudstore</h3>
				<div class="font-big font-thin margin-bottom">Let's get your store online today!</div>
				<a class="ui button primary big margin-top" href="{{ route('manager.store.create') }}">Create my store</a>
			</div>
			@endif
		</div>
	</div>
</div>
@stop