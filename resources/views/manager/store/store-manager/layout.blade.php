<!doctype html>
<html lang="en">
<head>
@yield('title')

@include('manager.partials.meta_tags')

@include('manager.partials.styles')

@include('manager.partials.google_tag_manager')

@include('shared.facebook-pixel')

@yield('styles')
</head>
<body>
<div class="sidebar-container">
@include('manager.store.store-manager.partials.sidebar-navigation')
@include('manager.store.store-manager.partials.store-header')

<div class="store-manager-content">
@include('manager.store.store-manager.partials.messages')
@yield('content')
<div class="store-manager-content-footer font-small extra text-center">
Made with <i class="fa fa-heart"></i> by the Cloudstore team
</div>
</div>
@include('manager.partials.scripts')
@yield('scripts')

@if(session('_notifyMessage'))
@include('shared.notification', ['section' => '_notifyMessage'])
@endif

</body>
</html>
