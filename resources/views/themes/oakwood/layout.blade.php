<!doctype html>
<html lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#">
@yield('title')
@include($storeTheme.'.partials.meta_tags')
@yield('meta_tags')
@include($storeTheme.'.partials.styles')
@yield('styles')
</head>
<body>
@include($storeTheme.'.partials.navbar')
@yield('content')
@include($storeTheme.'.partials.footer')
@include($storeTheme.'.partials.scripts')
@yield('scripts')

@if( Auth::guest() )
@include($storeTheme.'.partials.login')
@include('auth.partials.facebook-login')
<script>
$('#loginModal').modal('attach events', '.login_btn', 'show').modal('attach events', '#closeLogin', 'hide');
@if ( $errors->has('auth_error') )	
$('#loginModal').modal('show');
@endif
</script>
@endif
</body>
</html>
