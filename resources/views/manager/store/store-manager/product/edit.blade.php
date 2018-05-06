@extends('manager.store.store-manager.layout')

@section('title')
<title>Edit {{$product['title']}} &rsaquo; {{ config('app.name')}}</title>
@stop

@section('content')
@include('manager.store.store-manager.product.partials.form')
@stop

