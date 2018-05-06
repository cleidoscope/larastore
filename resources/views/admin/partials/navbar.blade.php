<div class="ui menu">
	<div class="ui container">
  		<a class="@if( Request::is('store*') ) active @endif item" href="{{ route('admin.store.index') }}">Stores</a>
  		<a class="@if( Request::is('user*') ) active @endif item" href="{{ route('admin.user.index') }}">Users</a>
  		<a class="item">Invoices</a>
  		<a class="item">Orders</a>
  		<a class="item">Products</a>
  	</div>
</div>