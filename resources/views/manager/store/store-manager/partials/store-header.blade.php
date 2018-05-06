<div class="ui secondary menu inverted no-margin-bottom" id="store-header">
  <div class="header store-icon-header font-medium">
    <div>{{ $store->name }}</div>
  </div>
  <div class="header item">
    <div id="mobile-menu" class="pointer">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="right menu">
  	<div class="ui dropdown item margin-right">
        	<i class="fa fa-user-o"></i>
        	<div class="menu">
  	        <a class="item" href="{{ route('manager.store.index') }}">My Stores</a>
            <a class="item" href="{{ route('manager.order.index') }}">My Orders</a>
  	        <a class="item" href="{{ route('manager.invoice.index') }}">Invoices</a>
            <a class="item" href="{{ route('manager.user.show') }}">Account Settings</a>
            <form method="POST" action="{{ route('auth.logout') }}">
              {{csrf_field()}}
              <button type="submit" class="ui fluid button flat font-light">Logout</button>
            </form>
        	</div>
      </div>
  </div>
</div>