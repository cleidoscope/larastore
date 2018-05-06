<!doctype html>
<html lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#">
@yield('title')
@include($storeTheme.'.partials.meta_tags')
@yield('meta_tags')
@include($storeTheme.'.partials.styles')
@yield('styles')
@include('shared.subdomain-analytics')
@include('shared.facebook-pixel')
</head>
<body>


@include($storeTheme.'.partials.navbar')
<main>
@yield('content')
</main>
@include($storeTheme.'.partials.footer')
@include($storeTheme.'.partials.scripts')
@yield('scripts')

@if (Session::has('subscribe_success'))
@include($storeTheme.'.partials.subscribe-success')
@endif

@if( Auth::guest() )
@include($storeTheme.'.partials.login')
@include('auth.partials.facebook-login')

<script>
$('#loginModal').modal('attach events', '.login_btn', 'show').modal('attach events', '#closeLogin', 'hide');
@if ( $errors->has('auth_error') )	
$('#loginModal').modal('show');
@endif
$('#loginModal form')
.form({
fields: {
	email : ['empty', 'email'],
  	password : 'empty',
}
});
</script>
@endif

<script>
@if (Session::has('subscribe_success'))
$('#subscribeModal').modal('attach events', '#closeSubscribe', 'hide');
$('#subscribeModal').modal('show');
@endif
</script>
@if( Helpers::isValidFacebookPage($store->facebook) )
<a href="https://m.me/{{ $store->facebook }}" target="_blank" class="fb_messenger"><img src="{{ asset('images/facebook-messenger.png') }}">Message Us</a>
@endif
</body>
</html>
