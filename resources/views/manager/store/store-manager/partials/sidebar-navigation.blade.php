<div id="cs-sidebar">
    <div class="menu-container">
        <div class="ui menu vertical compact fluid">
            <div class="header item">
            </div>
            <a class="item @if (Route::currentRouteName() == 'manager.store.show') active blue @endif" href="{{ route('manager.store.show', $store->id) }}">
                <i class="fa fa-tachometer"></i>Dashboard
            </a>
            <a class="item @if (Request::is('my-account/store/*/product*')) active blue @endif" href="{{ route('manager.product.index', $store->id) }}">
                <i class="fa fa-cubes"></i>Products
            </a>
            <a class="item @if (Route::currentRouteName() == 'manager.category.index') active blue @endif" href="{{ route('manager.category.index', $store->id) }}">
                <i class="fa fa-tags"></i>Categories
            </a>
            <a class="item @if (Route::currentRouteName() == 'manager.review.index') active blue @endif" href="{{ route('manager.review.index', $store->id) }}">
                <i class="fa fa-star"></i>Product Reviews
            </a>
            <a class="item @if (Request::is('my-account/store/*/order*')) active blue @endif" href="{{ route('manager.store-order.index', $store->id) }}">
                <i class="fa fa-shopping-basket"></i>Orders
            </a>
            <a class="item @if( $store->is_basic ) disabled @endif @if (Route::currentRouteName() == 'manager.voucher.index') active blue @endif" @if( !$store->is_basic ) href="{{ route('manager.voucher.index', $store->id) }}" @endif>
                <i class="fa fa-ticket"></i>Vouchers
            </a>
            <a class="item @if( $store->is_basic ) disabled @endif @if (Route::currentRouteName() == 'manager.newsletter.index') active blue @endif" @if( !$store->is_basic ) href="{{ route('manager.newsletter.index', $store->id) }}" @endif>
                <i class="fa fa-envelope"></i>Newsletters
            </a>
            <a class="item @if( $store->is_basic ) disabled @endif @if (Route::currentRouteName() == 'manager.store-subscriber.index') active blue @endif" @if( !$store->is_basic ) href="{{ route('manager.store-subscriber.index', $store->id) }}" @endif>
                <i class="fa fa-users   "></i>Subscribers
            </a>
            <a class="item @if (Request::is('my-account/store/*/appearance*')) active blue @endif" href="{{ route('manager.store.appearance.themes', $store->id) }}">
              <i class="fa fa-paint-brush"></i>Appearance
            </a>
            <a class="item @if (Request::is('my-account/store/*/settings*')) active blue @endif" href="{{ route('manager.store.settings.general', $store->id) }}">
              <i class="fa fa-gear"></i>Settings
            </a>
            <div class="item sidebar-footer-meta"></div>
        </div>
        <div class="sidebar-footer">
            <a href="{{ $store->url }}" target="_blank"><i class="fa fa-eye"></i>&nbsp;&nbsp;View store</a>
        </div>
    </div>
</div>


