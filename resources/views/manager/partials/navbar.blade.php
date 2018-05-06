<nav>
  <div class="ui grid container">
    <div class="computer only row">
      <div class="ui fluid secondary menu">
        <div class="header item">
          <a href="{{ route('manager.homepage') }}" class="navbar-logo"><img src="{{asset('logo.svg')}}"></a>
        </div>
        <a class="item @if( Route::currentRouteName() == 'manager.pricing' ) active @endif" href="{{ route('manager.pricing') }}">Pricing</a>
        <a class="item @if( Route::currentRouteName() == 'manager.support' ) active @endif" href="{{ route('manager.support') }}">Support</a>
        <a class="item @if( Route::currentRouteName() == 'manager.contact' ) active @endif" href="{{ route('manager.contact') }}">Contact</a>

        <div class="right menu">
          
          @if( Auth::guest() )
          <div class="item">
            <div>
              <a class="ui circular small button" href="{{route('auth.login.form')}}">Log In</a>
              <a class="ui circular primary small button" href="{{route('auth.signup.form')}}">Sign Up</a>
            </div>
          </div>
          @else
          <div class="ui dropdown item">
            <i class="fa fa-user-o"></i>&nbsp;&nbsp;Hi {{Auth::user()->first_name}}&nbsp;
            <i class="fa fa-angle-down"></i>
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
          @endif
        </div>
      </div>
    </div>

    <div class="tablet mobile only row">
      <div class="ui fluid secondary menu no-margin-bottom">
        <div class="header item no-padding-left">
          <a href="{{route('manager.homepage')}}" class="navbar-logo"><img src="{{asset('logo.svg')}}"></a>
        </div>
        <div class="right menu">
          <a class="menu item no-padding-right toggle-container">
            <div class="ui basic icon toggle button">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </a>
        </div>
      </div>
      <div class="ui vertical accordion fluid secondary menu no-margin-top">
        <a class="item @if( Route::currentRouteName() == 'manager.pricing' ) active @endif" href="{{ route('manager.pricing') }}">Pricing</a>
        <a class="item @if( Route::currentRouteName() == 'manager.support' ) active @endif" href="{{ route('manager.support') }}">Support</a>
        <a class="item @if( Route::currentRouteName() == 'manager.contact' ) active @endif" href="{{ route('manager.contact') }}">Contact</a>
         @if( Auth::guest() )
          <div class="item">
            <div>
              <a class="ui circular small button" href="{{route('auth.login.form')}}">Log In</a>
              <a class="ui circular primary small button" href="{{route('auth.signup.form')}}">Sign Up</a>
            </div>
          </div>
          @else
          <div class="item">
            <div class="title">
              <i class="fa fa-user-o"></i>&nbsp;&nbsp;Hi {{Auth::user()->first_name}}&nbsp;
              <i class="fa fa-angle-down"></i>
            </div>
            <div class="content">
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
          @endif
      </div>
    </div>
  </div>
</nav>





