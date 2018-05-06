@extends('manager.store.store-manager.layout')

@section('title')
<title>Categories &rsaquo; {{$store->name}} &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
<button class="ui primary small circular small button right floated" id="addCategory">Add category</button>
<h2 class="no-margin-top no-margin-bottom">Categories</h2>
<div class="extra margin-bottom">Group your products by assigning them to categories.</div>
<div class="table-responsive margin-top">
<table class="ui unstackable table">
	@if(count($store->product_categories) > 0) 
	<thead>
		<tr>
			<th>Category</th>
			<th>Slug</th>
			<th>Products</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($store->product_categories()->paginate(25) as $productCategory)
		<tr class="top aligned">
			<td>{{ $productCategory->category }}</td>
			<td><em>{{ $productCategory->slug }}</em></td>
			<td>{{ $productCategory->products->count() }}</td>
			<td class="right aligned">
				<span class="font-small font-light">
					<a href="javascript:void(0)" class="editCategory underline" data-category="{{ $productCategory->category }}" data-action="{{ route('manager.category.update', ['store_id' => $store->id, 'id' => $productCategory->id]) }}">Edit</a>
					<span class="v-divider"></span>
					<a href="javascript:void(0)" class="deleteCategory underline" data-category="{{ $productCategory->category }}" data-action="{{ route('manager.category.destroy', ['store_id' => $store->id, 'id' => $productCategory->id]) }}">Delete</a>
				</span>
			</td>
		</tr>
		@endforeach
	</tbody>
	@else
	<tbody>
		<tr class="text-center text-muted">
			<td class="extra">No product categories.</td>
		</tr>
	</tbody>
	@endif
</table>
</div>

<div class="text-right margin-top"> 
{!! $store->product_categories()->paginate(25)->links('pagination.default') !!}
</div>

@include('manager.store.store-manager.category.partials.form')
@stop

